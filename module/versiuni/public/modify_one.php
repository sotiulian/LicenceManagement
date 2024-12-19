<?php
include '../config/db_connect.php';

include '../src/Versiune.php';
include '../../programs/src/Program.php';

$parent = new Versiune($conn);
$child = new Program($conn);

/* cand se vine din click pe linie de tabel de modificat */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* initializez cu cheia de parent cu care s-a intrat in fereastra din read_all */
    $parent->keyid = $_POST['keyid']; // pastreaza $parent->keyid pentru read_single()

    /* scrie forma de modify_one */
    $stmt = $parent->read_single();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $parent->numar = $row['numar'];
    $parent->filename = $row['filename'];
    $parent->nume = $row['nume'];
    $parent->keyid_programe = $row['keyid_programe'];

    /* incarca $stmt_child cu lista de copii posibili */
    $child->keyid = $row['keyid_programe'];
    $stmt_child = $child->read(); 

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify Version</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php include '../config/navbar.php'; ?>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Modify Version</h2>
                <form method="post" action="modify_handlerform.php">
                    <input type="hidden" name="formname" value="modifyuserdata">
                    <input type="hidden" id="keyid" name="keyid" value="<?php echo $parent->keyid; ?>">
                    <div class="form-group">
                        <label for="numar">Numar:</label>
                        <input type="text" class="form-control" id="numar" name="numar" value="<?php echo $parent->numar; ?>">
                    </div>
                    <div class="form-group">
                        <label for="filename">Filename:</label>
                        <input type="text" class="form-control" id="filename" name="filename" value="<?php echo $parent->filename; ?>">
                    </div>
                    <div class="form-group">
                        <label for="issys">Sys Module</label>
                        <?php 
                        echo '<select id="keyid_child" name="keyid_child" class="form-control">';
                        while ($row_child = $stmt_child->fetch(PDO::FETCH_ASSOC)) {
                                $selected = ($row['keyid_programe'] == $row_child['keyid']) ? 'selected' : '';
                                echo '<option value="' . $row_child['keyid'] . '" ' . $selected . '>' . $row_child['nume'] . '</option>';
                            }
                        echo '</select>';
                        ?>
                    </div>
                    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this parent?');">Delete</button>
                    <button type="submit" name="save" class="btn btn-primary">Update</button>
                </form>       
            </div>
        </div>
    </div>
</body>
</html>
