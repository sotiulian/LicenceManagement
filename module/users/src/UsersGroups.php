<?php
// src/UsersGroups.php

class UsersGroups {
    private $conn;
    private $table = 'users_groups';

    public $keyid;
    public $keyid_groups;
    public $keyid_users;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (keyid_groups, keyid_users) VALUES (:keyid_groups, :keyid_users)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_groups', $this->keyid_groups);
        $stmt->bindParam(':keyid_users', $this->keyid_users);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        return $stmt->execute();
    }

    public function read() {
        $query = 'SELECT keyid, keyid_groups, keyid_users FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT keyid_groups, keyid_users FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    public function read_usergroups() {
        $query = 'SELECT groups.keyid as keyid_groups, :keyid_users as keyid_users, groups.nume, groups.isadmin, groups.issysadmin
                        , CASE WHEN users_groups.keyid_users = :keyid_users THEN 1 ELSE 0 END as isassociated
                  FROM groups
                  left JOIN (SELECT keyid_groups, keyid_users
                             FROM ' . $this->table . '
                            WHERE keyid_users = :keyid_users
                            ) users_groups ON users_groups.keyid_groups = groups.keyid
                   ORDER BY groups.nume
                  ';                                    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_users', $this->keyid_users, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /* trebuie sa existe stored procedure: manage_users_groups */
    /* creeaza combinatia users-groups in tabelul one-to-many daca nu exista inca si o sterge daca exista */
    /* functionalitatea aceasta este necesara la click pe forma din interfata in casuta isassociated */
    public function set_usersgroups() {
        $query = ' CALL manage_users_groups(:keyid_groups, :keyid_users); ';

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_groups', $this->keyid_groups);
        $stmt->bindParam(':keyid_users', $this->keyid_users);
        
        return $stmt->execute();
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET keyid_groups = :keyid_groups, keyid_users = :keyid_users WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_groups', $this->keyid_groups);
        $stmt->bindParam(':keyid_users', $this->keyid_users);
        $stmt->bindParam(':keyid', $this->keyid);
        
        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT keyid, keyid_groups, keyid_users FROM ' . $this->table . ' LIMIT :start, :limit';
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

    public function filter_users($keyid_groups, $keyid_users, $start, $limit) {
        $query = 'SELECT keyid, keyid_groups, keyid_users FROM ' 
                . $this->table 
                . ' WHERE keyid_groups =:keyid_groups AND keyid_users = :keyid_users LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_groups', $keyid_groups, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_users', $keyid_users, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($keyid_groups, $keyid_users) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table . ' WHERE keyid_groups = :keyid_groups AND keyid_users = :keyid_users';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid_groups', $keyid_groups, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_users', $keyid_users, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

}
?>
