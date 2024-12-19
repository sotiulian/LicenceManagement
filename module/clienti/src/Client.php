<?php


class Client {
    private $conn;
    private $table = 'clienti';

    public $keyid;
    public $nume;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (nume) VALUES (:nume)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nume', $this->nume);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = 'CALL delete_parent_and_child_dynamic(:parenttable, :keyid,  @result);'
                . 'SELECT @result;';        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':parenttable', $this->table);
        $stmt->bindParam(':keyid', $this->keyid);
        return $stmt->execute();
    }

    public function read() {
        $query = 'SELECT keyid, nume FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT nume FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET nume = :nume WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nume', $this->nume);
        $stmt->bindParam(':keyid', $this->keyid);
        
        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT keyid, nume FROM ' . $this->table . ' LIMIT :start, :limit';
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

    public function filter_users($nume, $start, $limit) {
        $query = 'SELECT keyid, nume FROM ' 
                . $this->table 
                . ' WHERE nume LIKE :nume '
                . ' ORDER BY nume ASC'
                . ' LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $nume = "%$nume%"; # prepare for SQL Like
        $stmt->bindParam(':nume', $nume, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($nume) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table . ' WHERE nume LIKE :nume';
        $stmt = $this->conn->prepare($query);
        $nume = "%$nume%";
        $stmt->bindParam(':nume', $nume, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

}
?>
