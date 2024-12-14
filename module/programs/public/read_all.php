<?php

include '../config/db_connect.php';
include '../src/Program.php';

$tableobject = new Program($conn);

$limit = 15;
$page = 1;
$start = 0;

$nume = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $start = ($page - 1) * $limit;

    $nume = isset($_POST['nume']) ? $_POST['nume'] : '';

}

/*
echo $nume;
*/

$total_rows = $tableobject->count_filtered($nume);
$total_pages = ceil($total_rows / $limit);

$stmt = $tableobject->filter_table($nume, $start, $limit);

// Calculate how many records are set with admin and sysadmin rights
$admin_sum = 0;
$sysadmin_sum = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    #echo $row['nume'];
    $admin_sum ++;
}

// Reset the statement to fetch rows again for display
$stmt->execute();

$content = 'read_all_content.php';
$contentfc = 'read_all_content_fc.php';

include('../config/layout.php');

?>