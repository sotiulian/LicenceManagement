<?php
session_start();
include '../config/db_connect.php';

// verifica daca modulul este accesibil de catre userul logat
include '../../../config/module_access.php';
check_module_access($conn, 'licence', $_SESSION['keyid_users']);

include '../src/Licence.php';
include '../../clienti/src/Client.php'; // pentru a putea afisa lista cu numele clientilor in dropdown
include '../../versiuni/src/Versiune.php'; // pentru a putea afisa lista cu numarul versiunilor in dropdown
include '../../programs/src/Program.php'; // pentru a putea afisa lista cu numele programelor in dropdown

$tableobject = new Licence($conn);
$client = new Client($conn);
$versiune = new Versiune($conn);
$program = new Program($conn);

$limit = 15;
$page = 1;
$start = 0;

/* initializez variabilele de pagina inainte de a vedea care vin prin $_POST */
$keyid_clienti = 0;
$keyid_versiuni = 0;
$keyid_programe = 0; 
$numeserver = ''; 
$datalimita_start = date('1000-01-01');
$datalimita_end = date('2999-m-d'); 
$frecventaheartbeat_start = 0;
$frecventaheartbeat_end = 9999;
$ultimulheartbeat_start = date('1000-01-01');
$ultimulheartbeat_end = date('2999-m-d'); 
$catelinii_start = 0;
$catelinii_end = 9999;
$cateplc_start = 0;
$cateplc_end = 9999;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $start = ($page - 1) * $limit;

    $keyid_clienti = isset($_POST['keyid_clienti']) ? $_POST['keyid_clienti'] : 0;
    $keyid_versiuni = isset($_POST['keyid_versiuni']) ? $_POST['keyid_versiuni'] : 0;
    $keyid_programe = isset($_POST['keyid_programe']) ? $_POST['keyid_programe'] : 0;
    $numeserver = isset($_POST['numeserver']) ? $_POST['numeserver'] : ''; 
    
    $datalimita_start = isset($_POST['datalimita_start']) ? $_POST['datalimita_start'] : date('1000-01-01'); 
    $datalimita_end = isset($_POST['datalimita_end']) ? $_POST['datalimita_end'] : date('2999-m-d');
    $frecventaheartbeat_start = isset($_POST['frecventaheartbeat_start']) ? $_POST['frecventaheartbeat_start'] : 0;
    $frecventaheartbeat_end = isset($_POST['frecventaheartbeat_end']) ? $_POST['frecventaheartbeat_end'] : 9999;
    $ultimulheartbeat_start = isset($_POST['ultimulheartbeat_start']) ? $_POST['ultimulheartbeat_start'] : date('1000-01-01'); 
    $ultimulheartbeat_end = isset($_POST['ultimulheartbeat_end']) ? $_POST['ultimulheartbeat_end'] : date('2999-m-d');
    $catelinii_start = isset($_POST['catelinii_start']) ? $_POST['catelinii_start'] : 0;
    $catelinii_end = isset($_POST['catelinii_end']) ? $_POST['catelinii_end'] : 9999;
    $cateplc_start = isset($_POST['cateplc_start']) ? $_POST['cateplc_start'] : 0;
    $cateplc_end = isset($_POST['cateplc_end']) ? $_POST['cateplc_end'] : 9999;    

}

$total_rows = $tableobject->count_filtered($keyid_clienti, $keyid_versiuni, $keyid_programe, $numeserver
, $datalimita_start, $datalimita_end
, $frecventaheartbeat_start, $frecventaheartbeat_end
, $ultimulheartbeat_start, $ultimulheartbeat_end
, $catelinii_start, $catelinii_end
, $cateplc_start, $cateplc_end);
$total_pages = ceil($total_rows / $limit);

$stmt = $tableobject->filter_table($keyid_clienti, $keyid_versiuni, $keyid_programe, $numeserver
, $datalimita_start, $datalimita_end
, $frecventaheartbeat_start, $frecventaheartbeat_end
, $ultimulheartbeat_start, $ultimulheartbeat_end
, $catelinii_start, $catelinii_end
, $cateplc_start, $cateplc_end
, $start, $limit); // citeste datele versiunii alese

$stmt_clienti = $client->read(); // citeste datele programelor pentru dropdown din filter criteria
$stmt_versiuni = $versiune->read(); // citeste datele programelor pentru dropdown din filter criteria
$stmt_programe = $program->read(); // citeste datele programelor pentru dropdown din filter criteria

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