<?php

class ClientiFurnizori {
    private $conn;
    private $table = 'clienti_furnizori';

    public $keyid;
    public $keyid_childs;
    public $keyid_parent;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (keyid_clienti, keyid_furnizori) VALUES (:keyid_childs, :keyid_parent)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_childs', $this->keyid_childs);
        $stmt->bindParam(':keyid_parent', $this->keyid_parent);
        
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
        $query = 'SELECT keyid, keyid_clienti, keyid_furnizori FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT keyid_clienti, keyid_furnizori FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    public function read_parentchilds() {
        $query = 'SELECT furnizori.keyid as keyid_childs, :keyid_parent as keyid_parent, furnizori.nume
                        , CASE WHEN furnizori_clienti.keyid_clienti = :keyid_parent THEN 1 ELSE 0 END as isassociated
                  FROM furnizori
                  left JOIN (SELECT keyid_clienti, keyid_furnizori
                             FROM ' . $this->table . '
                            WHERE keyid_clienti = :keyid_parent
                            ) furnizori_clienti ON furnizori_clienti.keyid_furnizori = furnizori.keyid
                   ORDER BY furnizori.nume
                  ';                                    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_parent', $this->keyid_parent, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /* trebuie sa existe stored procedure: manage_users_groups */
    /* creeaza combinatia users-clienti in tabelul one-to-many daca nu exista inca si o sterge daca exista */
    /* functionalitatea aceasta este necesara la click pe forma din interfata in casuta isassociated */
    public function set_parentchilds() {
        $query = ' CALL manage_clienti_furnizori(:keyid_furnizori, :keyid_clienti); ';

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_furnizori', $this->keyid_childs);
        $stmt->bindParam(':keyid_clienti', $this->keyid_parent);
        
        return $stmt->execute();
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET keyid_clienti = :keyid_parent, keyid_furnizori = :keyid_childs WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_childs', $this->keyid_childs);
        $stmt->bindParam(':keyid_parent', $this->keyid_parent);
        $stmt->bindParam(':keyid', $this->keyid);
        
        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT keyid, keyid_clienti, keyid_furnizori FROM ' . $this->table . ' LIMIT :start, :limit';
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

    public function filter_users($keyid_childs, $keyid_parent, $start, $limit) {
        $query = 'SELECT keyid, keyid_clienti, keyid_furnizori FROM ' 
                . $this->table 
                . ' WHERE keyid_clienti =:keyid_parent AND keyid_furnizori = :keyid_childs LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_childs', $keyid_childs, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_parent', $keyid_parent, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($keyid_childs, $keyid_parent) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table . ' WHERE keyid_clienti = :keyid_parent AND keyid_furnizori = :keyid_childs';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_childs', $keyid_childs, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_parent', $keyid_parent, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

}
?>
