issys<?php
include '../config/db_connect.php';

include '../src/Modul.php';
include '../src/ModulesGroups.php';

$parent = new Modul($conn);
$parentchild = new ModulesGroups($conn);

/* cand se vine din click pe linie de tabel de modificat */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['formname']) && $_POST['formname'] === 'read_all_child_content') {
        /* daca modify_one a fost chemat prin click de pe formularul modifyusergroup din read_all_child_content, se salveaza alegerea */
        $parent->keyid = $_POST['keyid_parent']; // pastreaza $parent->keyid pentru read_single()
        $parentchild->keyid_parent = $_POST['keyid_parent'];
        $parentchild->keyid_child = $_POST['keyid_child'];
        $stmt_child = $parentchild->set_parentchild();
    } else {
        /* initializez cu cheia de parent cu care s-a intrat in fereastra din read_all */
        $parent->keyid = $_POST['keyid']; // pastreaza $parent->keyid pentru read_single()
        $parentchild->keyid_parent = $_POST['keyid'];
        // de keyid_child nu este nevoie pentru ca se va seta pe forma read_all_child_content
    }

    /* citeste din baza de date care sunt legaturile deja existente intre users si groups si le incarca in $stmt_child de unde vor fi luate de forma read_all_child_content */
    $stmt_child = $parentchild->read_parentchild(); // fetch este in while-ul din read_all_child_content.php

    /* scrie forma de modify_one */
    $stmt = $parent->read_single();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $parent->nume = $row['nume'];
    $parent->modul = $row['modul'];
    $parent->issys = $row['issys'];

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify Module</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php include '../config/navbar.php'; ?>
    
    <div class="container">
        <div class="row">
        <div class="col-6">
        <h2>Modify Module</h2>
        <form method="post" action="modify_handlerform.php"  onsubmit="return validateForm(event)">
            <input type="hidden" name="formname" value="modifyuserdata">
            <input type="hidden" id="keyid" name="keyid" value="<?php echo $parent->keyid; ?>">
            <div class="form-group">
                <label for="nume">Nume:</label>
                <input type="text" class="form-control" id="nume" name="nume" value="<?php echo $parent->nume; ?>">
            </div>
            <div class="form-group">
                <label for="modul">Modul:</label>
                <input type="text" class="form-control" id="modul" name="modul" value="<?php echo $parent->modul; ?>">
            </div>
            <div class="form-group">
                <label for="issys">Sys Module</label>
                <select id="issys" name="issys" class="form-control">
                    <option value="0" <?php echo ($parent->issys == 0 ? 'selected' : '') ?>>Not Sys Module</option>
                    <option value="1" <?php echo ($parent->issys == 1 ? 'selected' : '') ?>>Sys Module</option>
                </select>  
            </div>
            <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this parent?');">Delete</button>
            <button type="submit" name="save" class="btn btn-primary">Update</button>
        </form>       
        </div>
        <div class="col-6">
            <h2>Associate Modul with Groups</h2>
            <?php include 'read_all_child_content.php'; ?>
        </div>
        </div>
    </div>
    <script>
        function validateForm() {

            let keyid = document.getElementById("keyid").value.trim();
            let nume = document.getElementById("nume").value.trim();
            let modul = document.getElementById("modul").value.trim();
            let issys = document.getElementById("issys").value;
            let errors = [];

            if (nume === "") {
                errors.push("Nume is required.");
            }

            if (modul === "") {
                errors.push("Modul is required.");
            } 
            
            if (event.submitter && event.submitter.name === 'save') {

            }   

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }

            return true;
        }

        <?php if (!empty($errors)): ?>
            alert("<?php echo $error_message; ?>");
        <?php endif; ?>
    </script>    
</body>
</html>
