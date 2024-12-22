<?php

include '../config/db_connect.php';
include '../src/Licence.php';

$tableobject = new Licence($conn);

/* cand se vine din butonul submit de pe forma de modificare */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete'])) {
        
        // Handle DELETE logic 
        $tableobject->keyid = $_POST['keyid'];

        if ($tableobject->delete()) {
            header("Location: read_all.php");
            exit();
        } else {
            $_SESSION['message']= "Failed to delete record.";
        }

    } else {

        // Handle SAVE logic
        $tableobject->keyid = $_POST['keyid'];

        $keyid_clienti = $_POST['keyid_clienti'];
        $keyid_versiuni = $_POST['keyid_versiuni'];
        $numeserver = trim($_POST['numeserver']);
        $datalimita = trim($_POST['datalimita']);
        $frecventaheartbeat = $_POST['frecventaheartbeat'];
        $catelinii = $_POST['catelinii'];
        $cateplc = $_POST['cateplc'];
            
        $tableobject->keyid_clienti = $keyid_clienti; 
        $tableobject->keyid_versiuni = $keyid_versiuni; 
        $tableobject->numeserver = $numeserver; 
        $tableobject->datalimita = $datalimita; 
        $tableobject->frecventaheartbeat = $frecventaheartbeat; 
        $tableobject->catelinii = $catelinii; 
        $tableobject->cateplc = $cateplc;

        if ($tableobject->update()) {
            header("Location: read_all.php");
            exit();
        } else {
            $_SESSION['message']= "Failed to update record.";
        }
    } 

} else {
    // daca e prin GET, nu se intampla nimic
    echo "alert('Method is {$_SERVER["REQUEST_METHOD"]}!')";
} 

?>