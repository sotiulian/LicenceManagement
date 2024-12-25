<?php
function check_module_access($conn, $module, $keyid_users) {
    include '../../modules/src/Modul.php';
    $modulobject = new Modul($conn);
    $modulobject->modul = $module;
    $stmtmodul = $modulobject->is_accessible_by_keyid_users($keyid_users);
    $match = false;
    while ($rowmodul = $stmtmodul->fetch(PDO::FETCH_ASSOC)) {
        if ($rowmodul['accesible'] && $_SESSION['authenticated']) {
            $match = true;
        }
    }
    if (!$match) {
        header('Location: ../../../index.php');
        exit();
    }
}
?>