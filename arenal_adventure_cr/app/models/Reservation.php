<?php
class Reservation {
 private PDO $db;
 public function __construct(){ $this->db=Database::connect(); }

 public function hotelAvailable(int $hotelId,string $checkIn,string $checkOut):bool{
  $hotel=(new Hotel())->find($hotelId);
  if(!$hotel || !(int)$hotel['status'] || (int)$hotel['rooms']<1){return false;}
  $st=$this->db->prepare('SELECT COUNT(*) FROM reservations WHERE hotel_id=? AND status IN ("pending","confirmed") AND check_in < ? AND check_out > ?');
  $st->execute([$hotelId,$checkOut,$checkIn]);
  return (int)$st->fetchColumn() < (int)$hotel['rooms'];
 }

 public function activityAvailable(int $activityId,int $people,string $checkIn,string $checkOut):bool{
  $activity=(new Activity())->find($activityId);
  if(!$activity || !(int)$activity['status']){return false;}
  $st=$this->db->prepare('SELECT COALESCE(SUM(ra.people),0) FROM reservation_activities ra JOIN reservations r ON r.id=ra.reservation_id WHERE ra.activity_id=? AND r.status IN ("pending","confirmed") AND r.check_in < ? AND r.check_out > ?');
  $st->execute([$activityId,$checkOut,$checkIn]);
  return ((int)$st->fetchColumn()+$people) <= (int)$activity['max_capacity'];
 }

 public function create(array $d,array $activityIds):int{
  $this->db->beginTransaction();
  try{
   $st=$this->db->prepare('INSERT INTO reservations(user_id,hotel_id,check_in,check_out,people,total,status,notes) VALUES(?,?,?,?,?,? ,"pending",?)');
   $st->execute([$d['user_id'],$d['hotel_id'],$d['check_in'],$d['check_out'],$d['people'],$d['total'],$d['notes']]);
   $id=(int)$this->db->lastInsertId();
   $sa=$this->db->prepare('INSERT INTO reservation_activities(reservation_id,activity_id,people,subtotal) SELECT ?,id,?,price*? FROM activities WHERE id=?');
   foreach($activityIds as $a){$sa->execute([$id,$d['people'],$d['people'],$a]);}
   $this->db->commit(); return $id;
  }catch(Throwable $e){$this->db->rollBack();throw $e;}
 }

 public function find(int $id):?array{$st=$this->db->prepare('SELECT * FROM reservations WHERE id=?');$st->execute([$id]);return $st->fetch()?:null;}
 public function updateStatus(int $id,string $status):bool{$st=$this->db->prepare('UPDATE reservations SET status=? WHERE id=?');return $st->execute([$status,$id]);}
 public function delete(int $id):bool{$st=$this->db->prepare('DELETE FROM reservations WHERE id=?');return $st->execute([$id]);}
 public function byUser(int $id):array{$st=$this->db->prepare('SELECT r.*,h.name hotel_name,d.name destination_name FROM reservations r LEFT JOIN hotels h ON h.id=r.hotel_id LEFT JOIN destinations d ON d.id=h.destination_id WHERE r.user_id=? ORDER BY r.id DESC');$st->execute([$id]);return $st->fetchAll();}
 public function all():array{return $this->db->query('SELECT r.*,u.name user_name,h.name hotel_name,d.name destination_name FROM reservations r JOIN users u ON u.id=r.user_id LEFT JOIN hotels h ON h.id=r.hotel_id LEFT JOIN destinations d ON d.id=h.destination_id ORDER BY r.id DESC')->fetchAll();}

 public function reports(string $from='',string $to=''):array{
  $where='';$params=[];
  if($from!==''&&$to!==''){$where=' WHERE DATE(r.created_at) BETWEEN ? AND ?';$params=[$from,$to];}
  $st=$this->db->prepare('SELECT DATE(r.created_at) fecha,COUNT(*) total,COALESCE(SUM(CASE WHEN r.status<>"cancelled" THEN r.total ELSE 0 END),0) ingresos FROM reservations r'.$where.' GROUP BY DATE(r.created_at) ORDER BY fecha DESC');$st->execute($params);
  $dateReport=$st->fetchAll();
  return [
   'summary'=>$this->db->query('SELECT (SELECT COUNT(*) FROM users) users,(SELECT COUNT(*) FROM reservations) reservations,(SELECT COUNT(*) FROM destinations) destinations,(SELECT COALESCE(SUM(total),0) FROM reservations WHERE status<>"cancelled") income')->fetch(),
   'destinations'=>$this->db->query('SELECT d.name,COUNT(r.id) total FROM destinations d LEFT JOIN hotels h ON h.destination_id=d.id LEFT JOIN reservations r ON r.hotel_id=h.id GROUP BY d.id ORDER BY total DESC')->fetchAll(),
   'hotels'=>$this->db->query('SELECT h.name,COUNT(r.id) total FROM hotels h LEFT JOIN reservations r ON r.hotel_id=h.id GROUP BY h.id ORDER BY total DESC LIMIT 10')->fetchAll(),
   'activities'=>$this->db->query('SELECT a.name,COUNT(ra.id) total FROM activities a LEFT JOIN reservation_activities ra ON ra.activity_id=a.id GROUP BY a.id ORDER BY total DESC LIMIT 10')->fetchAll(),
   'users'=>$this->db->query('SELECT id,name,email,role,status,created_at FROM users ORDER BY created_at DESC')->fetchAll(),
   'dates'=>$dateReport,
   'from'=>$from,'to'=>$to
  ];
 }
}
