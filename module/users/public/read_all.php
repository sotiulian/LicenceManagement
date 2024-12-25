<?php
session_start();
include '../config/db_connect.php';
include '../../../config/module_access.php';
check_module_access($conn, 'users', $_SESSION['keyid_users']);

include '../src/User.php';

$user = new User($conn);

$limit = 15;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$start = ($page - 1) * $limit;

$username = isset($_POST['username']) ? $_POST['username'] : '';
$timestampend_start = isset($_POST['timestampend_start']) ? $_POST['timestampend_start'] : date('1000-m-01');
$timestampend_end = isset($_POST['timestampend_end']) ? $_POST['timestampend_end'] : date('2999-m-d'); # vezi si metoda reset_form() din _content

$total_users = $user->count_filtered($username, $timestampend_start, $timestampend_end);
$total_pages = ceil($total_users / $limit);

$stmt = $user->filter_users($username, $timestampend_start, $timestampend_end, $start, $limit);

// Calculate the number of records
$row_count = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $row_count ++;
}

// Reset the statement to fetch rows again for display
$stmt->execute();

$content = 'read_all_content.php';
$contentfc = 'read_all_content_fc.php';

include('../config/layout.php');

?>