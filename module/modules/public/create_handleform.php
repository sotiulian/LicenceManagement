<?php

include '../config/db_connect.php';
include '../src/User.php';

$user = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $timestampend = trim($_POST['timestampend']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors[] = "username is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if (empty($timestampend)) {
        $errors[] = "Date of Birth is required.";
    }

    if (empty($errors)) {
        #$user = new User($conn);
        $user->username = $username;
        $user->timestampend = $timestampend;
        $user->password = password_hash($password, PASSWORD_DEFAULT);

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