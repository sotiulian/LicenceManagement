<?php

class ModulesGroups {

    private $conn;
    private $table = 'modules_groups';

    public $keyid;
    public $keyid_child;
    public $keyid_parent;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (keyid_groups, keyid_modules) VALUES (:keyid_groups, :keyid_modules)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_groups', $this->keyid_child);
        $stmt->bindParam(':keyid_modules', $this->keyid_parent);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        return $stmt->execute();
    }

    public function read() {
        $query = 'SELECT keyid, keyid_groups, keyid_modules FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT keyid_groups, keyid_modules FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    /* citeste toate grupurile din tabelul de grupuri si pune bifa isassociated la grupurile care au modul */
    public function read_parentchild() {
        $query = 'SELECT groups.keyid as keyid_child, :keyid_modules as keyid_parent, groups.nume, groups.isadmin, groups.issysadmin
                        , CASE WHEN modules_groups.keyid_modules = :keyid_modules THEN 1 ELSE 0 END as isassociated
                  FROM groups
                  left JOIN (SELECT keyid_groups, keyid_modules
                             FROM ' . $this->table . '
                            WHERE keyid_modules = :keyid_modules
                            ) modules_groups ON modules_groups.keyid_groups = groups.keyid
                   ORDER BY groups.nume
                  ';                                    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_modules', $this->keyid_parent, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /* trebuie sa existe stored procedure: manage_modules_groups */
    /* creeaza combinatia modules-groups in tabelul one-to-many daca nu exista inca si o sterge daca exista */
    /* functionalitatea aceasta este necesara la click pe forma din interfata in casuta isassociated */
    public function set_parentchild() {
        $query = ' CALL manage_modules_groups(:keyid_modules, :keyid_groups); ';
        echo $this->keyid_child . ' ' . $this->keyid_parent;
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_modules', $this->keyid_parent);
        $stmt->bindParam(':keyid_groups', $this->keyid_child);
        
        return $stmt->execute();
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET keyid_groups = :keyid_groups, keyid_modules = :keyid_modules WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_groups', $this->keyid_child);
        $stmt->bindParam(':keyid_modules', $this->keyid_parent);
        $stmt->bindParam(':keyid', $this->keyid);
        
        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT keyid, keyid_groups, keyid_modules FROM ' . $this->table . ' LIMIT :start, :limit';
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

    public function filter_modules($keyid_groups, $keyid_modules, $start, $limit) {
        $query = 'SELECT keyid, keyid_groups, keyid_modules FROM ' 
                . $this->table 
                . ' WHERE keyid_groups = :keyid_groups AND keyid_modules = :keyid_modules LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_groups', $keyid_groups, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_modules', $keyid_modules, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($keyid_groups, $keyid_modules) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table . ' WHERE keyid_groups = :keyid_groups AND keyid_modules = :keyid_modules';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_groups', $keyid_groups, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_modules', $keyid_modules, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

}
?>
