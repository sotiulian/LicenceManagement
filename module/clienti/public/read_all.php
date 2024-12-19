<?php

include '../config/db_connect.php';
include '../src/Client.php';

$tableobject = new Client($conn);

$limit = 15;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$start = ($page - 1) * $limit;

$nume = isset($_POST['nume']) ? $_POST['nume'] : '';

$total_records = $tableobject->count_filtered($nume);
$total_pages = ceil($total_records / $limit);

$stmt = $tableobject->filter_users($nume, $start, $limit);

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