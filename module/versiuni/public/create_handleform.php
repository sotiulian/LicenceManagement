<?php

include '../config/db_connect.php';
include '../src/Versiune.php';

$tableobject = new Versiune($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* pe aici trece dupa click in formular cand s-au completat deja toate campuriule cu valorile ce se doresc a fi salvate */

    $numar = trim($_POST['numar']);
    $filename = trim($_POST['filename']);
    $keyid_child = trim($_POST['keyid_child']);

    if (empty($numar)) {$errors[] = "Numar is required.";}
    if (empty($filename)) {$errors[] = "Filename is required.";} 
    if (empty($keyid_child)) {$errors[] = "Programe is required.";} 

    if (empty($errors)) {
        
        $tableobject->numar = $numar;
        $tableobject->filename = $filename;
        $tableobject->keyid_programe = $keyid_child;

        if (!$tableobject->create()) {$errors[] = "Failed to create record."; }
        
    } else {
        $error_message = implode("\\n", $errors);
    }
}

header("Location: create_one.php");
exit();

?>