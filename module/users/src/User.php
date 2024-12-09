<?php
// src/User.php

class User {
    private $conn;
    private $table = 'users';

    public $keyid;
    public $username;
    public $password;
    public $timestampend;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (username, password, timestampend) VALUES (:username, :password, :timestampend)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':timestampend', $this->timestampend);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        return $stmt->execute();
    }

    public function read() {
        $query = 'SELECT keyid, username, timestampend FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT username, timestampend FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET username = :username, password = :password, timestampend = :timestampend WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':timestampend', $this->timestampend);
        $stmt->bindParam(':keyid', $this->keyid);
        
        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT keyid, username, timestampend FROM ' . $this->table . ' LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_all() {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function filter_users($username, $timestampend_start, $timestampend_end, $start, $limit) {
        $query = 'SELECT keyid, username, timestampend FROM ' 
                . $this->table 
                . ' WHERE username LIKE :username AND timestampend BETWEEN :timestampend_start AND :timestampend_end LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $username = "%$username%"; # prepare for SQL Like
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':timestampend_start', $timestampend_start, PDO::PARAM_STR);
        $stmt->bindParam(':timestampend_end', $timestampend_end, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($username, $timestampend_start, $timestampend_end) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table . ' WHERE username LIKE :username AND timestampend BETWEEN :timestampend_start AND :timestampend_end';
        $stmt = $this->conn->prepare($query);
        $username = "%$username%";
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':timestampend_start', $timestampend_start);
        $stmt->bindParam(':timestampend_end', $timestampend_end);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

}
?>
