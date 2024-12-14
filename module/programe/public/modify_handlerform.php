<?php
include '../config/db_connect.php';
include '../src/Group.php';

$tableobject = new Group($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete'])) {
        
        // Handle delete logic 
        
        $tableobject->keyid = $_POST['keyid'];
        
        if ($tableobject->delete()) {
            $_SESSION['message'] = "Record deleted successfully";
            header("Location: read_all.php");
            exit();
        } else {
            $_SESSION['message']= "Failed to delete row.";
        }
    } else {

        // Handle save logic launched by submit button from this form
        
        $tableobject->keyid = $_POST['keyid'];
        $tableobject->nume = $_POST['nume'];
        $tableobject->isadmin = $_POST['isadmin'];
        $tableobject->issysadmin = $_POST['issysadmin'];
    
        if ($tableobject->update()) {
            $_SESSION['message'] = "Record updated successfully";
            header("Location: read_all.php");
            exit();
        } else {
            $_SESSION['message'] = "Error updating record";
        }    
    }

} else {


}
?>