<?php
include '../config/db_connect.php';
include '../src/Licence.php';

$tableobject = new Licence($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $keyid_clienti = $_POST['keyid_clienti'];
    $keyid_versiuni = $_POST['keyid_versiuni'];
    $numeserver = trim($_POST['numeserver']);
    $datalimita = trim($_POST['datalimita']);
    $frecventaheartbeat = $_POST['frecventaheartbeat'];
    $ultimulheartbeat = trim($_POST['ultimulheartbeat']);
    $catelinii = $_POST['catelinii'];
    $cateplc = $_POST['cateplc'];
        
    $tableobject->keyid_clienti = $keyid_clienti; 
    $tableobject->keyid_versiuni = $keyid_versiuni; 
    $tableobject->numeserver = $numeserver; 
    $tableobject->datalimita = $datalimita; 
    $tableobject->frecventaheartbeat = $frecventaheartbeat; 
    $tableobject->ultimulheartbeat = $ultimulheartbeat; 
    $tableobject->catelinii = $catelinii; 
    $tableobject->cateplc = $cateplc;

    $tableobject->create();

    header("Location: create_one.php");
    exit();
 
} else {
    echo "alert('Method is {$_SERVER["REQUEST_METHOD"]}!')";
}

?>