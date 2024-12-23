<?php

class Licence_log {

    private $conn;
    private $table = 'licence_log';

    public $keyid;
    public $keyid_licence;
    public $dataaccess;
    public $catecalculatoare;
    public $catestartari;
    public $cateplc;
    public $catelinii;
    public $catioperatori;
    public $catetablete;
    public $eroriprogram;

    public $numeserver;
    public $program_nume;
    public $versiune_nume;
    public $clienti_nume;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table 
        . ' (keyid_licence, dataaccess, catecalculatoare, catestartari, cateplc, catelinii, catioperatori, catetablete, eroriprogram) '
        . ' VALUES ' 
        . ' (:keyid_licence, :dataaccess, :catecalculatoare, :catestartari, :cateplc, :catelinii, :catioperatori, :catetablete, :eroriprogram)';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':keyid_licence', $this->keyid_licence);
        $stmt->bindParam(':dataaccess', $this->dataaccess);
        $stmt->bindParam(':catecalculatoare', $this->catecalculatoare);
        $stmt->bindParam(':catestartari', $this->catestartari);
        $stmt->bindParam(':cateplc', $this->cateplc);
        $stmt->bindParam(':catelinii', $this->catelinii);
        $stmt->bindParam(':catioperatori', $this->catioperatori);
        $stmt->bindParam(':catetablete', $this->catetablete);
        $stmt->bindParam(':eroriprogram', $this->eroriprogram);

        return $stmt->execute();
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        return $stmt->execute();
    }

    public function read() {
        $query = 'SELECT licence_log.*, licence.numeserver '
        . ' FROM ' . $this->table
        . ' JOIN licence ON licence.keyid = licence_log.keyid_licence';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT licence_log.*, licence.numeserver, programe.nume as program_nume, versiuni.numar as versiune_nume, clienti.nume as clienti_nume '
        . ' FROM ' . $this->table 
        . ' JOIN licence ON licence.keyid = licence_log.keyid_licence '
        . ' JOIN versiuni ON versiuni.keyid = licence.keyid_versiuni '
        . ' JOIN programe ON programe.keyid = versiuni.keyid_programe '
        . ' JOIN clienti ON clienti.keyid = licence.keyid_clienti '
        . ' WHERE licence_log.keyid = :keyid';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET '
            . ' keyid_licence = :keyid_licence, '
            . ' dataaccess = :dataaccess, '
            . ' catecalculatoare = :catecalculatoare, '
            . ' catestartari = :catestartari, '
            . ' cateplc = :cateplc, '
            . ' catelinii = :catelinii, '
            . ' catioperatori = :catioperatori, '
            . ' catetablete = :catetablete, '
            . ' eroriprogram = :eroriprogram '
            . ' WHERE keyid = :keyid';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':keyid', $this->keyid);
        $stmt->bindParam(':keyid_licence', $this->keyid_licence);
        $stmt->bindParam(':dataaccess', $this->dataaccess);
        $stmt->bindParam(':catecalculatoare', $this->catecalculatoare);
        $stmt->bindParam(':catestartari', $this->catestartari);
        $stmt->bindParam(':cateplc', $this->cateplc);
        $stmt->bindParam(':catelinii', $this->catelinii);
        $stmt->bindParam(':catioperatori', $this->catioperatori);
        $stmt->bindParam(':catetablete', $this->catetablete);
        $stmt->bindParam(':eroriprogram', $this->eroriprogram);

        return $stmt->execute();
    }

    public function read_with_pagination($start, $limit) {
        $query = 'SELECT licence_log.*, licence.numeserver '
        . ' FROM ' . $this->table 
        . ' JOIN licence ON licence.keyid = licence_log.keyid_licence'
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

    public function filter_table($numeserver, $keyid_licence, $dataaccess_start, $dataaccess_end, $catecalculatoare_start, $catecalculatoare_end, $catestartari_start, $catestartari_end, $keyid_versiuni, $keyid_clienti, $start, $limit) {
        $query = 'SELECT licence_log.*, licence.numeserver, programe.nume as program_nume, versiuni.numar as versiune_nume, clienti.nume as clienti_nume '
        . ' FROM ' . $this->table 
        . ' JOIN licence ON licence.keyid = licence_log.keyid_licence '
        . ' JOIN versiuni ON versiuni.keyid = licence.keyid_versiuni '
        . ' JOIN programe ON programe.keyid = versiuni.keyid_programe '
        . ' JOIN clienti ON clienti.keyid = licence.keyid_clienti '
        . ' WHERE licence.numeserver LIKE :numeserver AND '
        .       ' dataaccess BETWEEN :dataaccess_start AND :dataaccess_end AND '
        .       ' catecalculatoare BETWEEN :catecalculatoare_start AND :catecalculatoare_end AND '
        .       ' catestartari BETWEEN :catestartari_start AND :catestartari_end AND '
        .       ' ( :keyid_licence=0 OR licence_log.keyid_licence = :keyid_licence) AND '        
        .       ' ( :keyid_versiuni=0 OR licence.keyid_versiuni = :keyid_versiuni) AND '
        .       ' ( :keyid_clienti=0 OR licence.keyid_clienti = :keyid_clienti) '
        . ' ORDER BY licence_log.dataaccess DESC '
        . ' LIMIT :start, :limit ';
        $stmt = $this->conn->prepare($query);

        $numeserver = "%$numeserver%";
        $stmt->bindParam(':numeserver', $numeserver, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_licence', $keyid_licence, PDO::PARAM_INT);
        $stmt->bindParam(':dataaccess_start', $dataaccess_start, PDO::PARAM_STR);
        $stmt->bindParam(':dataaccess_end', $dataaccess_end, PDO::PARAM_STR);
        $stmt->bindParam(':catecalculatoare_start', $catecalculatoare_start, PDO::PARAM_INT);
        $stmt->bindParam(':catecalculatoare_end', $catecalculatoare_end, PDO::PARAM_INT);
        $stmt->bindParam(':catestartari_start', $catestartari_start, PDO::PARAM_INT);
        $stmt->bindParam(':catestartari_end', $catestartari_end, PDO::PARAM_INT);
        $stmt->bindParam(':keyid_versiuni', $keyid_versiuni, PDO::PARAM_INT);
        $stmt->bindParam(':keyid_clienti', $keyid_clienti, PDO::PARAM_INT);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function count_filtered($numeserver, $keyid_licence, $dataaccess_start, $dataaccess_end, $catecalculatoare_start, $catecalculatoare_end, $catestartari_start, $catestartari_end, $keyid_versiuni, $keyid_clienti) {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table 
        . ' JOIN licence ON licence.keyid = licence_log.keyid_licence'
        . ' JOIN versiuni ON versiuni.keyid = licence.keyid_versiuni'
        . ' JOIN clienti ON clienti.keyid = licence.keyid_clienti'
        . ' WHERE licence.numeserver LIKE :numeserver AND '
        .       ' dataaccess BETWEEN :dataaccess_start AND :dataaccess_end AND '
        .       ' catecalculatoare BETWEEN :catecalculatoare_start AND :catecalculatoare_end AND '
        .       ' catestartari BETWEEN :catestartari_start AND :catestartari_end AND '
        .       ' ( :keyid_licence=0 OR licence_log.keyid_licence = :keyid_licence) AND'        
        .       ' ( :keyid_versiuni=0 OR licence.keyid_versiuni = :keyid_versiuni) AND'
        .       ' ( :keyid_clienti=0 OR licence.keyid_clienti = :keyid_clienti)';
        $stmt = $this->conn->prepare($query);

        $numeserver = "%$numeserver%";
        $stmt->bindParam(':numeserver', $numeserver, PDO::PARAM_STR);
        $stmt->bindParam(':keyid_licence', $keyid_licence, PDO::PARAM_INT);
        $stmt->bindParam(':dataaccess_start', $dataaccess_start, PDO::PARAM_STR);
        $stmt->bindParam(':dataaccess_end', $dataaccess_end, PDO::PARAM_STR);
        $stmt->bindParam(':catecalculatoare_start', $catecalculatoare_start, PDO::PARAM_INT);
        $stmt->bindParam(':catecalculatoare_end', $catecalculatoare_end, PDO::PARAM_INT);
        $stmt->bindParam(':catestartari_start', $catestartari_start, PDO::PARAM_INT);
        $stmt->bindParam(':catestartari_end', $catestartari_end, PDO::PARAM_INT);
        $stmt->bindParam(':keyid_versiuni', $keyid_versiuni, PDO::PARAM_INT);
        $stmt->bindParam(':keyid_clienti', $keyid_clienti, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>