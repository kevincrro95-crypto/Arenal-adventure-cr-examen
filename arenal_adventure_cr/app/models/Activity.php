<?php
class Activity {
 private PDO $db; public function __construct(){ $this->db=Database::connect(); }
 public function all(int $destination=0):array{$sql='SELECT a.*,d.name destination_name FROM activities a JOIN destinations d ON d.id=a.destination_id';if($destination){$st=$this->db->prepare($sql.' WHERE a.destination_id=? ORDER BY a.name');$st->execute([$destination]);return $st->fetchAll();}return $this->db->query($sql.' ORDER BY a.name')->fetchAll();}
 public function active():array{return $this->db->query('SELECT a.*,d.name destination_name FROM activities a JOIN destinations d ON d.id=a.destination_id WHERE a.status=1 ORDER BY a.name')->fetchAll();}
 public function find(int $id):?array{$st=$this->db->prepare('SELECT * FROM activities WHERE id=?');$st->execute([$id]);return $st->fetch()?:null;}
 public function save(array $d):bool{$p=[$d['destination_id'],$d['name'],$d['type'],$d['description'],$d['price'],$d['duration'],$d['max_capacity'],$d['image'],$d['status']];if($d['id']){$p[]=$d['id'];$st=$this->db->prepare('UPDATE activities SET destination_id=?,name=?,type=?,description=?,price=?,duration=?,max_capacity=?,image=?,status=? WHERE id=?');}else{$st=$this->db->prepare('INSERT INTO activities(destination_id,name,type,description,price,duration,max_capacity,image,status) VALUES(?,?,?,?,?,?,?,?,?)');}return $st->execute($p);}
 public function delete(int $id):bool{$st=$this->db->prepare('DELETE FROM activities WHERE id=?');return $st->execute([$id]);}
}
