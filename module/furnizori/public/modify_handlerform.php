<?php

include '../config/db_connect.php';
include '../src/User.php';

$user = new User($conn);

/* cand se vine din butonul submit de pe forma de modificare */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete'])) {
        
        // Handle DELETE logic 
        $user->keyid = $_POST['keyid'];
        if ($user->delete()) {
            header("Location: read_all.php");
            exit();
        } else {
            $_SESSION['message']= "Failed to delete user.";
        }

    } else {
        
        // Handle SAVE logic
        $user->keyid = $_POST['keyid'];
        $user->username = $_POST['username'];
        $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $user->timestampend = $_POST['timestampend'];
    
        if ($user->update()) {
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