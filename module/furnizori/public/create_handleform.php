<?php

include '../config/db_connect.php';
include '../src/Furnizor.php';

$parent = new Furnizor($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nume = trim($_POST['nume']);

    if (empty($nume)) {$errors[] = "nume is required.";}

    if (empty($errors)) {
        
        $parent->nume = $nume;

        if (! $parent->create()) {$errors[] = "Failed to create record.";}

    } else {
        $error_message = implode("\\n", $errors);
    }

}

header("Location: create_one.php");
exit();

?>