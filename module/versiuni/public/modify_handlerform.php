<?php

include '../config/db_connect.php';
include '../src/Versiune.php';

$parent = new Versiune($conn);

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
        $parent->keyid = isset($_POST['keyid']) ? $_POST['keyid'] : '';
        $parent->numar = isset($_POST['numar']) ? $_POST['numar'] : '';
        $parent->filename = isset($_POST['filename']) ? $_POST['filename'] : '';
        $parent->keyid_programe = isset($_POST['keyid_child']) ? $_POST['keyid_child'] : 0;

        $errors = array();

        if (empty($parent->numar)) {$errors[] = "Numar is required.";}
        if (empty($parent->filename)) {$errors[] = "Filename is required.";}
        if (empty($parent->keyid_programe)) {$errors[] = "Programe is required.";}

        if (!empty($errors)) {
            $error_message = implode("\\n", $errors);
            $_SESSION['message'] = $error_message;
            echo '<script type="text/javascript">'; 
            echo 'alert("' . $error_message . '");'; 
            echo '</script>';

            echo '<tbody>'
                 .'<tr onclick="document.getElementById(\'form-repeat\').submit();">'
                 .'<form id="form-repeat" method="POST" action="modify_one.php">'
                 .'<input type="hidden" name="keyid" value="' . $parent->keyid . '">'
                 .'</form>'
                 .'</tr>'
                 .'</tbody>';
            echo '<script type="text/javascript"> document.getElementById("form-repeat").submit(); </script>';
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