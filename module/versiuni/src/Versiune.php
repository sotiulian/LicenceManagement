<?php


class Versiune {

    private $conn;
    private $table = 'versiuni';

    public $keyid;
    public $numar; // numele modulului asa cum va aparea in meniu
    public $filename; // numele modulului asa cum este definit in aplicatie pentru a fi incarcat de un anumituser
    public $keyid_programe; // specifica daca modulul poate fi pus doar pe grupul de sysadmin
    public $nume; // numele programului de care apartine aceasta versiune (relatia one-to-one)

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (numar, filename, keyid_programe) VALUES (:numar, :filename, :keyid_programe)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':numar', $this->numar);
        $stmt->bindParam(':filename', $this->filename);
        $stmt->bindParam(':keyid_programe', $this->keyid_programe);
        
        return $stmt->execute();
    }

    public function delete() {
        //$query = 'DELETE FROM ' . $this->table . ' WHERE keyid = :keyid';
        $query = 'CALL delete_parent_and_child_dynamic(:parenttable, :keyid,  @result);'
        . 'SELECT @result;';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':parenttable', $this->table);
        $stmt->bindParam(':keyid', $this->keyid);
        return $stmt->execute();
    }

    public function read() {
        $query = 'SELECT ' . $this->table . '.keyid, numar, filename, keyid_programe, programe.nume FROM ' . $this->table
        . ' JOIN programe ON versiuni.keyid_programe = programe.keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT numar, filename, keyid_programe, programe.nume  FROM ' . $this->table 
        . ' JOIN programe ON versiuni.keyid_programe = programe.keyid' 
        . ' WHERE versiuni.keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET numar = :numar, filename = :filename, keyid_programe = :keyid_programe WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':numar', $this->numar);
        $stmt->bindParam(':filename', $this->filename);
        $stmt->bindParam(':keyid_programe', $this->keyid_programe);
        $stmt->bindParam(':keyid', $this->keyid);
        
        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT versiuni.keyid, numar, filename, keyid_programe, programe.nume FROM ' . $this->table 
        . ' JOIN programe ON versiuni.keyid_programe = programe.keyid'
        . ' LIMIT :start, :limit';
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

    public function filter_table($numar, $filename, $keyid_programe, $start, $limit) {
        $query = 'SELECT versiuni.keyid, versiuni.numar, versiuni.filename, versiuni.keyid_programe, programe.nume FROM ' 
                . $this->table 
                . ' JOIN programe ON programe.keyid = versiuni.keyid_programe '
                . ' WHERE versiuni.numar LIKE :numar AND '
                .       ' versiuni.filename LIKE :filename AND '
                .       ' ( :keyid_programe=0 OR versiuni.keyid_programe LIKE :keyid_programe) '
                .' LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $numar = "%$numar%"; # prepare for SQL Like
        $filename = "%$filename%"; # prepare for SQL Like
        $stmt->bindParam(':numar', $numar, PDO::PARAM_STR);
        $stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_programe', $keyid_programe, PDO::PARAM_INT);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($numar, $filename, $keyid_programe) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table 
                . ' JOIN programe ON programe.keyid = versiuni.keyid_programe '
                . ' WHERE versiuni.numar LIKE :numar AND '
                .       ' versiuni.filename LIKE :filename AND '
                .       ' ( :keyid_programe=0 OR versiuni.keyid_programe LIKE :keyid_programe) ';
        $stmt = $this->conn->prepare($query);
        $numar = "%$numar%";
        $filename = "%$filename%"; # prepare for SQL Like
        $stmt->bindParam(':numar', $numar, PDO::PARAM_STR);
        $stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_programe', $keyid_programe, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

}
?>
