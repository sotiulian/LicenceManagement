<?php

include '../config/db_connect.php';
include '../src/Modul.php';

$module = new Modul($conn);

$limit = 15;
$page = 1;
$start = 0;

$nume = '';
$modul = ''; 
$issys = 2; // 2 means both cases: unchecked and checked

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $start = ($page - 1) * $limit;

    $nume = isset($_POST['nume']) ? $_POST['nume'] : '';
    $modul = isset($_POST['modul']) ? $_POST['modul'] : '';
    $issys = $_POST['issys'];
}

/*
echo $nume;
echo $modul;
echo $issys;
*/

$total_rows = $module->count_filtered($nume, $modul, $issys);
$total_pages = ceil($total_rows / $limit);

$stmt = $module->filter_table($nume, $modul, $issys, $start, $limit);

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