<?php
session_start();
include '../config/db_connect.php';

// verifica daca modulul este accesibil de catre userul logat
include '../../../config/module_access.php';
check_module_access($conn, 'licencelog', $_SESSION['keyid_users']);

include '../src/Licence_log.php';
include '../../clienti/src/Client.php'; // pentru a putea afisa lista cu numele clientilor in dropdown
include '../../versiuni/src/Versiune.php'; // pentru a putea afisa lista cu numarul versiunilor in dropdown
include '../../programs/src/Program.php'; // pentru a putea afisa lista cu numele programelor in dropdown

$tableobject = new Licence_log($conn);
$client = new Client($conn);
$versiune = new Versiune($conn);
$program = new Program($conn);

$limit = 15;
$page = 1;
$start = 0;

/* initializez variabilele de pagina inainte de a vedea care vin prin $_POST */
// Get filter criteria from POST request
$numeserver = isset($_POST['numeserver']) ? $_POST['numeserver'] : '';
$keyid_licence = isset($_POST['keyid_licence']) ? $_POST['keyid_licence'] : 0;
$keyid_versiuni = isset($_POST['keyid_versiuni']) ? $_POST['keyid_versiuni'] : 0;
$keyid_clienti = isset($_POST['keyid_clienti']) ? $_POST['keyid_clienti'] : 0;
$dataaccess_start = isset($_POST['dataaccess_start']) ? $_POST['dataaccess_start'] : date('Y-m-01');
$dataaccess_end = isset($_POST['dataaccess_end']) ? $_POST['dataaccess_end'] : date('2999-12-31');
$catecalculatoare_start = isset($_POST['catecalculatoare_start']) ? $_POST['catecalculatoare_start'] : 0;
$catecalculatoare_end = isset($_POST['catecalculatoare_end']) ? $_POST['catecalculatoare_end'] : 9999;
$catestartari_start = isset($_POST['catestartari_start']) ? $_POST['catestartari_start'] : 0;
$catestartari_end = isset($_POST['catestartari_end']) ? $_POST['catestartari_end'] : 9999;
$start = isset($_POST['start']) ? $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? $_POST['limit'] : 10;

// Calculate total rows and total pages
$total_rows = $tableobject->count_filtered($numeserver, $keyid_licence, $dataaccess_start, $dataaccess_end, $catecalculatoare_start, $catecalculatoare_end, $catestartari_start, $catestartari_end, $keyid_versiuni, $keyid_clienti);
$total_pages = ceil($total_rows / $limit);

// Fetch filtered data
$stmt = $tableobject->filter_table($numeserver, $keyid_licence, $dataaccess_start, $dataaccess_end, $catecalculatoare_start, $catecalculatoare_end, $catestartari_start, $catestartari_end, $keyid_versiuni, $keyid_clienti, $start, $limit);

// Fetch data for dropdowns
$stmt_clienti = $client->read();
$stmt_versiuni = $versiune->read();
$stmt_programe = $program->read();

// Calculate the number of records
$row_count = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $row_count++;
}

// Reset the statement to fetch rows again for display
$stmt->execute();

$content = 'read_all_content.php';
$contentfc = 'read_all_content_fc.php';

include('../config/layout.php');
?>