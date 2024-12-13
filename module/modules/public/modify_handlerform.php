<?php

include '../config/db_connect.php';
include '../src/Modul.php';

$parent = new Modul($conn);

/* cand se vine din butonul submit de pe forma de modificare */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete'])) {
        
        // Handle DELETE logic 
        $parent->keyid = $_POST['keyid'];
        if ($parent->delete()) {
            header("Location: read_all.php");
            exit();
        } else {
            $_SESSION['message']= "Failed to delete record.";
        }

    } else {
        
        // Handle SAVE logic
        $parent->keyid = $_POST['keyid'];
        $parent->nume = $_POST['nume'];
        $parent->modul = $_POST['modul'];
        $parent->issys = $_POST['issys'];

        if ($parent->update()) {
            
            header("Location: read_all.php");
            exit();            
            $_SESSION['message'] = "Record updated successfully";
        } else {
            $_SESSION['message'] = "Error updating record";
        }    
    }

} else {
    // daca e prin GET, nu se intampla nimic
}
?>