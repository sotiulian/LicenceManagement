<?php
session_start();
include '../config/db_connect.php';

// verifica daca modulul este accesibil de catre userul logat
include '../../../config/module_access.php';
check_module_access($conn, 'versiuni', $_SESSION['keyid_users']);

include '../src/Versiune.php';
include '../../programs/src/Program.php'; // pentru a putea afisa lista cu numele programelor in dropdown

$versiune = new Versiune($conn);
$program = new Program($conn);

$limit = 15;
$page = 1;
$start = 0;

$numar = '';
$filename = ''; 
$keyid_programe = 0; 
$nume = ''; // programe.nume

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $start = ($page - 1) * $limit;

    $numar = isset($_POST['numar']) ? $_POST['numar'] : '';
    $filename = isset($_POST['filename']) ? $_POST['filename'] : '';
    $keyid_programe = isset($_POST['keyid_child']) ? $_POST['keyid_child'] : 0;
    
}


$total_rows = $versiune->count_filtered($numar, $filename, $keyid_programe);
$total_pages = ceil($total_rows / $limit);

$stmt = $versiune->filter_table($numar, $filename, $keyid_programe, $start, $limit); // citeste datele versiunii alese
$stmt_child = $program->read(); // citeste datele programelor pentru dropdown din filter criteria

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