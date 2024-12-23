<?php

include '../config/db_connect.php';
include '../src/Licence_log.php';

$tableobject = new Licence_log($conn);

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
            
        $tableobject->keyid_licence = $_POST['keyid_licence']; 
        $tableobject->numeserver = $_POST['numeserver']; 
        $tableobject->program_nume = $_POST['program_nume']; 
        $tableobject->versiune_nume = $_POST['versiune_nume']; 
        $tableobject->clienti_nume = $_POST['clienti_nume']; 
        $tableobject->dataaccess = $_POST['dataaccess'];
        $tableobject->catecalculatoare = $_POST['catecalculatoare'];
        $tableobject->catestartari = $_POST['catestartari'];
        $tableobject->catelinii = $_POST['catelinii']; 
        $tableobject->cateplc = $_POST['cateplc'];
        $tableobject->catioperatori = $_POST['catioperatori'];
        $tableobject->catetablete = $_POST['catetablete'];
        $tableobject->eroriprogram = $_POST['eroriprogram'];
        /* this form is just to show the data, not to update it
        if ($tableobject->update()) {
            header("Location: read_all.php");
            exit();
        } else {
            $_SESSION['message']= "Failed to update record.";
        }
        */
        header("Location: read_all.php");
        exit();        
    } 

} else {
    // daca e prin GET, nu se intampla nimic
    echo "alert('Method is {$_SERVER["REQUEST_METHOD"]}!')";
} 

?>