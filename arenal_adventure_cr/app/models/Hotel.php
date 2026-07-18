<?php
class Hotel {
 private PDO $db; public function __construct(){ $this->db=Database::connect(); }
 public function all(int $destination=0):array{ $sql='SELECT h.*,d.name destination_name FROM hotels h JOIN destinations d ON d.id=h.destination_id'; if($destination){$st=$this->db->prepare($sql.' WHERE h.destination_id=? ORDER BY h.name');$st->execute([$destination]);return $st->fetchAll();} return $this->db->query($sql.' ORDER BY h.name')->fetchAll(); }
 public function active():array{return $this->db->query('SELECT h.*,d.name destination_name FROM hotels h JOIN destinations d ON d.id=h.destination_id WHERE h.status=1 ORDER BY h.name')->fetchAll();}
 public function find(int $id):?array{$st=$this->db->prepare('SELECT * FROM hotels WHERE id=?');$st->execute([$id]);return $st->fetch()?:null;}
 public function save(array $d):bool{ $p=[$d['destination_id'],$d['name'],$d['category'],$d['address'],$d['phone'],$d['email'],$d['price_per_night'],$d['rooms'],$d['description'],$d['image'],$d['status']]; if($d['id']){$p[]=$d['id'];$st=$this->db->prepare('UPDATE hotels SET destination_id=?,name=?,category=?,address=?,phone=?,email=?,price_per_night=?,rooms=?,description=?,image=?,status=? WHERE id=?');}else{$st=$this->db->prepare('INSERT INTO hotels(destination_id,name,category,address,phone,email,price_per_night,rooms,description,image,status) VALUES(?,?,?,?,?,?,?,?,?,?,?)');} return $st->execute($p);}
 public function delete(int $id):bool{$st=$this->db->prepare('DELETE FROM hotels WHERE id=?');return $st->execute([$id]);}
}
