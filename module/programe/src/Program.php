<?php
// src/Group.php

class Program {

    private $conn;
    private $table = 'groups';

    public $keyid;
    public $nume;
    public $isadmin;
    public $issysadmin;


    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (nume, isadmin, issysadmin) VALUES (:nume, :isadmin, :issysadmin)';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nume', $this->nume);
        $stmt->bindParam(':isadmin', $this->isadmin, PDO::PARAM_BOOL);
        $stmt->bindParam(':issysadmin', $this->issysadmin, PDO::PARAM_BOOL);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function read() {
        $query = 'SELECT keyid, nume, isadmin, issysadmin FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT nume, isadmin, issysadmin FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET nume = :nume, isadmin = :isadmin, issysadmin = :issysadmin WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nume', $this->nume, PDO::PARAM_STR);
        $stmt->bindParam(':isadmin', $this->isadmin, PDO::PARAM_BOOL);
        $stmt->bindParam(':issysadmin', $this->issysadmin, PDO::PARAM_BOOL);
        $stmt->bindParam(':keyid', $this->keyid, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT keyid, nume, isadmin, issysadmin FROM ' . $this->table . ' LIMIT :start, :limit';
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

    public function filter_table($nume, $isadmin, $issysadmin, $start, $limit) {
        $query = 'SELECT keyid, nume, isadmin, issysadmin FROM ' . $this->table 
             . ' WHERE nume LIKE :nume '
             . ' AND CASE WHEN :isadmin = 0 THEN NOT isadmin '
             .           'WHEN :isadmin = 1 THEN isadmin '
             .           'ELSE 1 END '
             . ' AND CASE WHEN :issysadmin = 0 THEN NOT issysadmin '
             .           'WHEN :issysadmin = 1 THEN issysadmin '
             .           'ELSE 1 END '
             . ' LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $nume = "%$nume%"; // prepare for SQL Like
        $stmt->bindParam(':nume', $nume, PDO::PARAM_STR);
        $stmt->bindParam(':isadmin', $isadmin, PDO::PARAM_INT);
        $stmt->bindParam(':issysadmin', $issysadmin, PDO::PARAM_INT);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($nume, $isadmin, $issysadmin) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table 
            . ' WHERE nume LIKE :nume '
            . ' AND CASE WHEN :isadmin = 0 THEN NOT isadmin '
            .           'WHEN :isadmin = 1 THEN isadmin '
            .           'ELSE 1 END '
            . ' AND CASE WHEN :issysadmin = 0 THEN NOT issysadmin '
            .           'WHEN :issysadmin = 1 THEN issysadmin '
            .           'ELSE 1 END ';
        $stmt = $this->conn->prepare($query);
        $nume = "%$nume%";
        $stmt->bindParam(':nume', $nume, PDO::PARAM_STR);
        $stmt->bindParam(':isadmin', $isadmin, PDO::PARAM_INT);
        $stmt->bindParam(':issysadmin', $issysadmin, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>
