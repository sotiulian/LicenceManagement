<?php
include '../config/db_connect.php';
include '../src/Versiune.php';
include '../../programs/src/Program.php';

$tableobject = new Versiune($conn);
$child = new Program($conn);

$errors = [];
$numar = '';
$filename = '';
$keyid_programe = 0;

$stmt_child = $child->read(); // citeste datele programelor pentru dropdown

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* pe aici ajunge la prima intrare daca a venit de undeva din afara acestui formular, prin POST */

    $numar = trim($_POST['numar']);
    $filename = $_POST['filename'];
    $keyid_programe = $_POST['keyid_programe'];

    if (empty($numar)) {$errors[] = "Numar is required.";}
    if (empty($filename)) {$errors[] = "Filename is required.";}
    if (empty($keyid_programe)) {$errors[] = "Programe is required.";}

    if (empty($errors)) {

        $tableobject = new Versiune($conn);
        
        $tableobject->numar = $numar;
        $tableobject->filename = $filename;
        $tableobject->keyid_programe = $keyid_programe;

        if ($group->create()) {
            header("Location: create_one.php");
            exit();
        } else {
            $errors[] = "Failed to create Versiune.";
        }
    } else {
        $error_message = implode("\\n", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta username="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Version</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
    <?php include '../config/navbar.php'; ?>

    <div class="container">
        <h2>Create Version</h2>
        <form method="POST" action="create_handleform.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="numar">Nume</label>
                <input type="text" id="numar" name="numar" class="form-control" value="<?php echo htmlspecialchars($numar); ?>">
            </div>
            <div class="form-group">
                <label for="filename">Modul</label>
                <input type="text" id="filename" name="filename" class="form-control">
            </div>
            <div class="form-group">
                <label for="keyid_child">Program</label>
                <?php 
                echo '<select id="keyid_child" name="keyid_child" class="form-control">';
                       echo '<option value="0" selected></option>'; // add an extra item to prevent the default chosing of the first record without notice
                 while ($row_child = $stmt_child->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row['keyid_programe'] == $row_child['keyid']) ? 'selected' : '';
                        echo '<option value="' . $row_child['keyid'] . '" ' . $selected . '>' . $row_child['nume'] . '</option>';
                       }
                echo '</select>';
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>