<?php
class Destination {
    private PDO $db;
    public function __construct(){ $this->db=Database::connect(); }
    public function all(string $search=''): array {
        if($search!==''){ $st=$this->db->prepare('SELECT * FROM destinations WHERE name LIKE ? OR province LIKE ? ORDER BY name'); $st->execute(["%$search%","%$search%"]); return $st->fetchAll(); }
        return $this->db->query('SELECT * FROM destinations ORDER BY name')->fetchAll();
    }
    public function active(): array { return $this->db->query('SELECT * FROM destinations WHERE status=1 ORDER BY name')->fetchAll(); }
    public function find(int $id): ?array { $st=$this->db->prepare('SELECT * FROM destinations WHERE id=?');$st->execute([$id]);return $st->fetch()?:null; }
    public function save(array $d): bool {
        if(!empty($d['id'])){ $st=$this->db->prepare('UPDATE destinations SET name=?,province=?,description=?,image=?,latitude=?,longitude=?,status=? WHERE id=?'); return $st->execute([$d['name'],$d['province'],$d['description'],$d['image'],$d['latitude'],$d['longitude'],$d['status'],$d['id']]); }
        $st=$this->db->prepare('INSERT INTO destinations(name,province,description,image,latitude,longitude,status) VALUES(?,?,?,?,?,?,?)'); return $st->execute([$d['name'],$d['province'],$d['description'],$d['image'],$d['latitude'],$d['longitude'],$d['status']]);
    }
    public function delete(int $id): bool { $st=$this->db->prepare('DELETE FROM destinations WHERE id=?'); return $st->execute([$id]); }
}
