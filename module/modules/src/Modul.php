<?php


class Modul {

    private $conn;
    private $table = 'modules';

    public $keyid;
    public $nume; // numele modulului asa cum va aparea in meniu
    public $modul; // numele modulului asa cum este definit in aplicatie pentru a fi incarcat de un anumituser
    public $issys; // specifica daca modulul poate fi pus doar pe grupul de sysadmin

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (nume, modul, issys) VALUES (:nume, :modul, :issys)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nume', $this->nume);
        $stmt->bindParam(':modul', $this->modul);
        $stmt->bindParam(':issys', $this->issys);
        
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
        $query = 'SELECT keyid, nume, modul, issys FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT nume, modul, issys FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    public function is_accessible_by_keyid_users($keyid_users) {
        $query = 'SELECT true as accesible '
        . ' FROM ' . $this->table 
        . ' JOIN modules_groups ON modules_groups.keyid_modules = ' . $this->table . '.keyid '
        . ' JOIN groups ON groups.keyid = modules_groups.keyid_groups '
        . ' JOIN users_groups ON users_groups.keyid_groups = groups.keyid '     
        . ' WHERE ' . $this->table . '.modul = :modul AND '
        .        ' users_groups.keyid_users = :keyid_users '
        . ' LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':modul', $this->modul);
        $stmt->bindParam(':keyid_users', $keyid_users);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET nume = :nume, modul = :modul, issys = :issys WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nume', $this->nume);
        $stmt->bindParam(':modul', $this->modul);
        $stmt->bindParam(':issys', $this->issys, PDO::PARAM_BOOL);
        $stmt->bindParam(':keyid', $this->keyid);
        
        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT keyid, nume, modul, issys FROM ' . $this->table . ' LIMIT :start, :limit';
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

    public function filter_table($nume, $modul, $issys, $start, $limit) {
        $query = 'SELECT keyid, nume, modul, issys FROM ' 
                . $this->table 
                . ' WHERE nume LIKE :nume AND '
                .       ' modul LIKE :modul AND '
                .       ' CASE WHEN :issys = 0 THEN NOT issys '
                .             'WHEN :issys = 1 THEN issys '
                .             'ELSE 1 END '
                .' LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $nume = "%$nume%"; # prepare for SQL Like
        $modul = "%$modul%"; # prepare for SQL Like
        $stmt->bindParam(':nume', $nume, PDO::PARAM_STR);
        $stmt->bindParam(':modul', $modul, PDO::PARAM_STR);
        $stmt->bindParam(':issys', $issys, PDO::PARAM_INT);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($nume, $modul, $issys) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table 
        . ' WHERE nume LIKE :nume AND '
        . ' modul LIKE :modul AND '
        . ' CASE WHEN :issys = 0 THEN NOT issys '
        .       ' WHEN :issys = 1 THEN issys '
        .       ' ELSE 1 END ';
        $stmt = $this->conn->prepare($query);
        $nume = "%$nume%";
        $modul = "%$modul%"; # prepare for SQL Like
        $stmt->bindParam(':nume', $nume, PDO::PARAM_STR);
        $stmt->bindParam(':modul', $modul, PDO::PARAM_STR);
        $stmt->bindParam(':issys', $issys, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

}
?>
