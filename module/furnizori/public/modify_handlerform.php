<?php

include '../config/db_connect.php';
include '../src/Furnizor.php';

$parent = new Furnizor($conn);

/* cand se vine din butonul submit de pe forma de modificare */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['delete'])) {
        
        // Handle DELETE logic 
        $parent->keyid = $_POST['keyid'];
        if ($parent->delete()) {
            header("Location: read_all.php");
            exit();
        } else {
            $_SESSION['message']= "Failed to delete record.";
        }

    } else {
        
        // Handle SAVE logic
        $parent->keyid = $_POST['keyid'];
        $parent->nume = $_POST['nume'];
    
        $errors = array();

        if (empty($parent->nume)) {$errors[] = "Nume is required.";}

        if (!empty($errors)) {
            $error_message = implode("\\n", $errors);
            $_SESSION['message'] = $error_message;
            echo '<script type="text/javascript">'
                . 'alert("' . $error_message . '");'
                . '</script>';
            /* creeaza o forma intr-un tabel ca sa poata sa dea submit automat si astfel sa reincarce modify_one furnizandu-i prin POST pe keyid */
            echo '<tbody>'
                 .'<tr onclick="document.getElementById(\'form-repeat\').submit();">'
                 .'<form id="form-repeat" method="POST" action="modify_one.php">'
                 .'<input type="hidden" name="keyid" value="' . $parent->keyid . '">'
                 .'</form>'
                 .'</tr>'
                 .'</tbody>'
                . '<script type="text/javascript"> document.getElementById("form-repeat").submit(); </script>';
            exit();              
        } else
        if ($parent->update()) {          
            $_SESSION['message'] = "Record updated successfully";
            header("Location: read_all.php");
            exit();              
        } else {
            $_SESSION['message'] = "Error updating record";
        }    
    }

} else {
    // daca e prin GET, nu se intampla nimic
}
?>