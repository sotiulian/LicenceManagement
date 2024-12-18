<?php
include '../config/db_connect.php';

include '../src/Furnizor.php';
include '../src/ClientiFurnizori.php';

$parent = new Furnizor($conn);
$parentchilds = new ClientiFurnizori($conn);

/* cand se vine din click pe linie de tabel de modificat sau din click pe forma de asociere*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['formname']) && $_POST['formname'] === 'read_all_child_content') {

        /* daca modify_one a fost chemat prin click de pe formularul modifyusergroup din read_all_child_content, se salveaza alegerea */
        
        $parent->keyid = $_POST['keyid_parent']; // pastreaza $parent->keyid pentru read_single()
        $parentchilds->keyid_parent = $_POST['keyid_parent'];
        $parentchilds->keyid_childs = $_POST['keyid_childs'];

        $stmt_child = $parentchilds->set_parentchilds();

    } else {
        
        /* initializez cu cheia de parent cu care s-a intrat in fereastra din read_all */
        
        $parent->keyid = $_POST['keyid']; // pastreaza $parent->keyid pentru read_single()
        $parentchilds->keyid_parent = $_POST['keyid'];
        // de keyid_clienti nu este nevoie pentru ca se va seta pe forma read_all_child_content
    }

    /* citeste din baza de date care sunt legaturile deja existente intre users si groups si le incarca in $stmt_child de unde vor fi luate de forma read_all_child_content */
    $stmt_child = $parentchilds->read_parentchilds(); // fetch este in while-ul din read_all_child_content.php

    /* scrie forma de modify_one */
    $stmt = $parent->read_single();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $parent->nume = $row['nume'];

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify Furnizor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php include '../config/navbar.php'; ?>
    
    <div class="container">
        <div class="row">
        <div class="col-6">
        <h2>Modify furnizor</h2>
        <form method="post" action="modify_handlerform.php">
            <input type="hidden" name="formname" value="modifyuserdata">
            <input type="hidden" id="keyid" name="keyid" value="<?php echo $parent->keyid; ?>">
            <div class="form-group">
                <label for="nume">username:</label>
                <input type="text" class="form-control" id="nume" name="nume" value="<?php echo $parent->nume; ?>">
            </div>
            <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
            <button type="submit" name="save" class="btn btn-primary">Update</button>
        </form>       
        </div>
        <div class="col-6">
            <h2>Associate <?php echo $parent->nume; ?> with Clienti</h2>
            <?php include 'read_all_child_content.php'; ?>
        </div>
        </div>
    </div> 
</body>
</html>
