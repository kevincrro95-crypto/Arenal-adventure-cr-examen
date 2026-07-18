<?php
class User {
    private PDO $db;
    public function __construct() { $this->db = Database::connect(); }

    public function findByEmail(string $email): ?array {
        $st=$this->db->prepare('SELECT * FROM users WHERE email=? AND status=1');
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }

    public function emailExists(string $email, int $ignoreId=0): bool {
        $sql='SELECT COUNT(*) FROM users WHERE email=?';
        $params=[$email];
        if($ignoreId>0){$sql.=' AND id<>?';$params[]=$ignoreId;}
        $st=$this->db->prepare($sql);$st->execute($params);
        return (int)$st->fetchColumn()>0;
    }

    public function find(int $id): ?array {
        $st=$this->db->prepare('SELECT id,name,email,phone,photo,role,status,created_at FROM users WHERE id=?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function create(array $d): bool {
        $role=$d['role']??'client';
        $status=(int)($d['status']??1);
        $st=$this->db->prepare('INSERT INTO users(name,email,phone,password,role,status) VALUES(?,?,?,?,?,?)');
        return $st->execute([$d['name'],$d['email'],$d['phone']??'',password_hash($d['password'],PASSWORD_DEFAULT),$role,$status]);
    }

    public function adminSave(array $d): bool {
        if(!empty($d['id'])){
            if(!empty($d['password'])){
                $st=$this->db->prepare('UPDATE users SET name=?,email=?,phone=?,role=?,status=?,password=? WHERE id=?');
                return $st->execute([$d['name'],$d['email'],$d['phone'],$d['role'],$d['status'],password_hash($d['password'],PASSWORD_DEFAULT),$d['id']]);
            }
            $st=$this->db->prepare('UPDATE users SET name=?,email=?,phone=?,role=?,status=? WHERE id=?');
            return $st->execute([$d['name'],$d['email'],$d['phone'],$d['role'],$d['status'],$d['id']]);
        }
        return $this->create($d);
    }

    public function updateProfile(int $id,array $d): bool {
        $st=$this->db->prepare('UPDATE users SET name=?,email=?,phone=?,photo=? WHERE id=?');
        return $st->execute([$d['name'],$d['email'],$d['phone'],$d['photo']??null,$id]);
    }

    public function changePassword(int $id,string $password): bool {
        $st=$this->db->prepare('UPDATE users SET password=? WHERE id=?');
        return $st->execute([password_hash($password,PASSWORD_DEFAULT),$id]);
    }

    public function delete(int $id): bool {
        $st=$this->db->prepare('DELETE FROM users WHERE id=?');
        return $st->execute([$id]);
    }

    public function all(): array {
        return $this->db->query('SELECT id,name,email,phone,photo,role,status,created_at FROM users ORDER BY id DESC')->fetchAll();
    }
}
