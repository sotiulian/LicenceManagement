<?php
session_start();
include 'db_connect.php';
include '../module/users/src/User.php';

$limit = 15;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$start = ($page - 1) * $limit;

/*
public $keyid;
public $username;
public $password;
public $timestampend;
*/
$tableobject = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $tableobject->username = $username;
    $tableobject->password;
    $timestampend_start = date('Y-m-d');
    $timestampend_end = date('2999-12-31');

    $stmt = $tableobject->filter_users($username, $timestampend_start, $timestampend_end, $start, $limit);

    //echo 'POST ' . $username . ' ' . $password . '<br>';
    //echo 'POST ' . $timestampend_start . ' ' . $timestampend_end . '<br>';
    //echo 'POST ' . $start . ' ' . $limit . '<br>';

    $_SESSION['authenticated'] = false;
    $_SESSION['keyid_users'] = '';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        // Check if the username exists and the password matches
        if (isset($row['username']) && $row['username'] === $username && 
            password_verify(isset($password)?$password:'', $row['password'])) {
            // Valid credentials
            $_SESSION['authenticated'] = true;
            $_SESSION['keyid_users'] = $row['keyid'];
            //echo 'Matched ' . $row['keyid'] . ' ' . $row['username'] . ' ' . $row['password'] . ' ' . $row['timestampend'] . '<br>';
        } else {
            //echo 'NO matched ' . $row['keyid'] . ' ' . $row['username'] . ' ' . $row['password'] . ' ' . $row['timestampend'] . '<br>';
        }
    }

    // call back to the login page with GET method
    header('Location: ../index.php');
    exit();
}
?>