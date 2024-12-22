<?php


class Licence {

    private $conn;
    private $table = 'licence';

    public $keyid;
    public $keyid_clienti;
    public $keyid_versiuni;
    public $numeserver; 
    public $datalimita; 
    public $frecventaheartbeat;
    public $ultimulheartbeat; 
    public $catelinii;
    public $cateplc;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function create() {
        $query = 'INSERT INTO ' . $this->table 
        . ' (keyid_clienti, keyid_versiuni, numeserver, datalimita, frecventaheartbeat, ultimulheartbeat, catelinii, cateplc) '
        . ' VALUES ' 
        . ' (:keyid_clienti, :keyid_versiuni, :numeserver, :datalimita, :frecventaheartbeat, :ultimulheartbeat, :catelinii, :cateplc)';
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':keyid_clienti', $this->keyid_clienti);
        $stmt->bindParam(':keyid_versiuni', $this->keyid_versiuni);
        $stmt->bindParam(':numeserver', $this->numeserver);
        $stmt->bindParam(':datalimita', $this->datalimita);
        $stmt->bindParam(':frecventaheartbeat', $this->frecventaheartbeat);
        $stmt->bindParam(':ultimulheartbeat', $this->ultimulheartbeat);
        $stmt->bindParam(':catelinii', $this->catelinii);
        $stmt->bindParam(':cateplc', $this->cateplc);
        
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
        $query = 'keyid_clienti, keyid_versiuni, numeserver, datalimita, frecventaheartbeat, ultimulheartbeat, catelinii, cateplc '
        . ' ,clienti.nume AS client, versiuni.numar AS versiune, programe.nume AS program '
        . ' FROM ' . $this->table
        . ' JOIN clienti ON clienti.keyid = ' . $this->table . '.keyid_clienti'
        . ' JOIN versiuni ON versiuni.keyid = ' . $this->table . '.keyid_versiuni'
        . ' JOIN programe ON programe.keyid = versiuni.keyid_programe';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT keyid_clienti, keyid_versiuni, numeserver, datalimita, frecventaheartbeat, ultimulheartbeat, catelinii, cateplc '
        . ' ,clienti.nume AS client, versiuni.numar AS versiune, versiuni.keyid_programe, programe.nume AS program '
        . ' FROM ' . $this->table 
        . ' JOIN clienti ON clienti.keyid = ' . $this->table . '.keyid_clienti'
        . ' JOIN versiuni ON versiuni.keyid = ' . $this->table . '.keyid_versiuni'
        . ' JOIN programe ON programe.keyid = versiuni.keyid_programe'
        . ' WHERE ' . $this->table . '.keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET '
            . ' keyid_clienti = :keyid_clienti, '
            . ' keyid_versiuni = :keyid_versiuni, '
            . ' numeserver = :numeserver, '
            . ' datalimita = :datalimita, '
            . ' frecventaheartbeat = :frecventaheartbeat, '
            . ' catelinii = :catelinii, '
            . ' cateplc = :cateplc '
            . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':keyid', $this->keyid);

        $stmt->bindParam(':keyid_clienti', $this->keyid_clienti);
        $stmt->bindParam(':keyid_versiuni', $this->keyid_versiuni);
        $stmt->bindParam(':numeserver', $this->numeserver);
        $stmt->bindParam(':datalimita', $this->datalimita);
        $stmt->bindParam(':frecventaheartbeat', $this->frecventaheartbeat);
        $stmt->bindParam(':catelinii', $this->catelinii);
        $stmt->bindParam(':cateplc', $this->cateplc);
        
        return $stmt->execute();
    }
    

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT keyid_clienti, keyid_versiuni, numeserver, datalimita, frecventaheartbeat, ultimulheartbeat, catelinii, cateplc '
        . ' clienti.nume AS client, versiuni.numar AS versiune, versiuni.keyid_programe, programe.nume AS program '
        . ' FROM ' . $this->table 
        . ' JOIN clienti ON clienti.keyid = ' . $this->table . '.keyid_clienti'
        . ' JOIN versiuni ON versiuni.keyid = ' . $this->table . '.keyid_versiuni'
        . ' JOIN programe ON programe.keyid = versiuni.keyid_programe'
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

    public function filter_table($keyid_clienti, $keyid_versiuni, $keyid_programe, $numeserver
    , $datalimita_start, $datalimita_end
    , $frecventaheartbeat_start, $frecventaheartbeat_end
    , $ultimulheartbeat_start, $ultimulheartbeat_end
    , $catelinii_start, $catelinii_end
    , $cateplc_start, $cateplc_end
    , $start, $limit
    ) {
        $query = 'SELECT ' . $this->table . '.keyid, keyid_clienti, keyid_versiuni, numeserver, datalimita, frecventaheartbeat, ultimulheartbeat, catelinii, cateplc '
        . ' ,clienti.nume AS client, versiuni.numar AS versiune, versiuni.keyid_programe, programe.nume AS program '
        . ' FROM ' . $this->table 
        . ' JOIN clienti ON clienti.keyid = ' . $this->table . '.keyid_clienti'
        . ' JOIN versiuni ON versiuni.keyid = ' . $this->table . '.keyid_versiuni'
        . ' JOIN programe ON programe.keyid = versiuni.keyid_programe'
        . ' WHERE numeserver LIKE :numeserver AND '
        .       ' datalimita BETWEEN :datalimita_start AND :datalimita_end AND '
        .       ' frecventaheartbeat BETWEEN :frecventaheartbeat_start AND :frecventaheartbeat_end AND '
        .       ' ultimulheartbeat BETWEEN :ultimulheartbeat_start AND :ultimulheartbeat_end AND '
        .       ' catelinii BETWEEN :catelinii_start AND :catelinii_end AND '
        .       ' cateplc BETWEEN :cateplc_start AND :cateplc_end AND '
        .       ' ( :keyid_clienti=0 OR licence.keyid_clienti = :keyid_clienti) AND'
        .       ' ( :keyid_versiuni=0 OR licence.keyid_versiuni = :keyid_versiuni) AND'
        .       ' ( :keyid_programe=0 OR versiuni.keyid_programe = :keyid_programe) '
        .' LIMIT :start, :limit';
        $stmt = $this->conn->prepare($query);
        $numeserver = "%$numeserver%"; # prepare for SQL Like
        $stmt->bindParam(':keyid_clienti', $keyid_clienti, PDO::PARAM_INT);
        $stmt->bindParam(':keyid_versiuni', $keyid_versiuni, PDO::PARAM_INT);
        $stmt->bindParam(':keyid_programe', $keyid_programe, PDO::PARAM_INT);
        $stmt->bindParam(':numeserver', $numeserver, PDO::PARAM_STR);
        $stmt->bindParam(':datalimita_start', $datalimita_start, PDO::PARAM_STR);
        $stmt->bindParam(':datalimita_end', $datalimita_end, PDO::PARAM_STR);
        $stmt->bindParam(':frecventaheartbeat_start', $frecventaheartbeat_start, PDO::PARAM_INT);
        $stmt->bindParam(':frecventaheartbeat_end', $frecventaheartbeat_end, PDO::PARAM_INT);
        $stmt->bindParam(':ultimulheartbeat_start', $ultimulheartbeat_start, PDO::PARAM_STR);
        $stmt->bindParam(':ultimulheartbeat_end', $ultimulheartbeat_end, PDO::PARAM_STR);
        $stmt->bindParam(':catelinii_start', $catelinii_start, PDO::PARAM_INT);
        $stmt->bindParam(':catelinii_end', $catelinii_end, PDO::PARAM_INT);
        $stmt->bindParam(':cateplc_start', $cateplc_start, PDO::PARAM_INT);
        $stmt->bindParam(':cateplc_end', $cateplc_end, PDO::PARAM_INT);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        //echo $query; 
        //print_r($stmt->debugDumpParams());        
        return $stmt;
    }

    public function count_filtered($keyid_clienti, $keyid_versiuni, $keyid_programe, $numeserver
        , $datalimita_start, $datalimita_end
        , $frecventaheartbeat_start, $frecventaheartbeat_end
        , $ultimulheartbeat_start, $ultimulheartbeat_end
        , $catelinii_start, $catelinii_end
        , $cateplc_start, $cateplc_end
        ) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table 
        . ' JOIN clienti ON clienti.keyid = ' . $this->table . '.keyid_clienti'
        . ' JOIN versiuni ON versiuni.keyid = ' . $this->table . '.keyid_versiuni'
        . ' JOIN programe ON programe.keyid = versiuni.keyid_programe'
        . ' WHERE numeserver LIKE :numeserver AND '
        .       ' datalimita BETWEEN :datalimita_start AND :datalimita_end AND '
        .       ' frecventaheartbeat BETWEEN :frecventaheartbeat_start AND :frecventaheartbeat_end AND '
        .       ' ultimulheartbeat BETWEEN :ultimulheartbeat_start AND :ultimulheartbeat_end AND '
        .       ' catelinii BETWEEN :catelinii_start AND :catelinii_end AND '
        .       ' cateplc BETWEEN :cateplc_start AND :cateplc_end AND '
        .       ' ( :keyid_clienti=0 OR licence.keyid_clienti = :keyid_clienti) AND'
        .       ' ( :keyid_versiuni=0 OR licence.keyid_versiuni = :keyid_versiuni) AND'
        .       ' ( :keyid_programe=0 OR versiuni.keyid_programe = :keyid_programe) ';
        $stmt = $this->conn->prepare($query);
        $numeserver = "%$numeserver%"; // prepare for SQL Like
        $stmt->bindParam(':keyid_clienti', $keyid_clienti, PDO::PARAM_INT);
        $stmt->bindParam(':keyid_versiuni', $keyid_versiuni, PDO::PARAM_INT);
        $stmt->bindParam(':keyid_programe', $keyid_programe, PDO::PARAM_INT);
        $stmt->bindParam(':numeserver', $numeserver, PDO::PARAM_STR);
        $stmt->bindParam(':datalimita_start', $datalimita_start, PDO::PARAM_STR);
        $stmt->bindParam(':datalimita_end', $datalimita_end, PDO::PARAM_STR);
        $stmt->bindParam(':frecventaheartbeat_start', $frecventaheartbeat_start, PDO::PARAM_INT);
        $stmt->bindParam(':frecventaheartbeat_end', $frecventaheartbeat_end, PDO::PARAM_INT);
        $stmt->bindParam(':ultimulheartbeat_start', $ultimulheartbeat_start, PDO::PARAM_STR);
        $stmt->bindParam(':ultimulheartbeat_end', $ultimulheartbeat_end, PDO::PARAM_STR);
        $stmt->bindParam(':catelinii_start', $catelinii_start, PDO::PARAM_INT);
        $stmt->bindParam(':catelinii_end', $catelinii_end, PDO::PARAM_INT);
        $stmt->bindParam(':cateplc_start', $cateplc_start, PDO::PARAM_INT);
        $stmt->bindParam(':cateplc_end', $cateplc_end, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

}
?>
