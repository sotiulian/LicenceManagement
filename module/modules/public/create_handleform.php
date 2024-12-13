<?php

include '../config/db_connect.php';
include '../src/Modul.php';

$user = new Modul($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nume = trim($_POST['nume']);
    $modul = trim($_POST['modul']);
    $issys = trim($_POST['issys']);

    if (empty($nume)) {
        $errors[] = "Nume is required.";
    }

    if (empty($modul)) {
        $errors[] = "Modul is required.";
    } 

    if (empty($errors)) {
        #$user = new User($conn);
        $user->nume = $nume;
        $user->modul = $modul;
        $user->issys = $issys;

        if ($user->create()) {
            header("Location: create_one.php");
            exit();
        } else {
            $errors[] = "Failed to create user.";
        }
    } else {
        $error_message = implode("\\n", $errors);
    }
}
?>