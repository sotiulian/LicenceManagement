<?php
include '../config/db_connect.php';
include '../src/Licence.php';
include '../../clienti/src/Client.php';
include '../../versiuni/src/Versiune.php';

$tableobject = new Licence($conn);
$client = new Client($conn);
$versiune = new Versiune($conn);

$errors = [];

$keyid_clienti = 0;
$keyid_versiuni = 0;
$numeserver = ''; 
$datalimita = date('2000-01-01');
$frecventaheartbeat = 0;
$ultimulheartbeat = date('2000-01-01');
$catelinii = 0;
$cateplc = 0;

$stmt_clienti = $client->read(); // citeste datele programelor pentru dropdown din filter criteria
$stmt_versiuni = $versiune->read(); // citeste datele programelor pentru dropdown din filter criteria


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* pe aici ajunge la prima intrare daca a venit de undeva din afara acestui formular, prin POST */

    $errors = array();

    $keyid_clienti = $_POST['keyid_clienti'];
    $keyid_versiuni = $_POST['keyid_versiuni'];
    $numeserver = trim($_POST['numeserver']);
    
    $datalimita = trim($_POST['datalimita']);
    $frecventaheartbeat = $_POST['frecventaheartbeat'];
    $ultimulheartbeat = trim($_POST['ultimulheartbeat']);
    $catelinii = $_POST['catelinii'];
    $cateplc = $_POST['cateplc'];
    
    if (empty($keyid_clienti)) { $errors[] = "Keyid_clienti is required."; }
    if (empty($keyid_versiuni)) { $errors[] = "Keyid_versiuni is required."; }
    if (empty($numeserver)) { $errors[] = "Numeserver is required."; }
    if (empty($datalimita)) { $errors[] = "Datalimita is required."; }
    if (empty($frecventaheartbeat)) { $errors[] = "Frecventa heartbeat is required."; }
    if (empty($ultimulheartbeat)) { $errors[] = "Ultimul heartbeat is required."; }
    if (empty($catelinii)) { $errors[] = "Catelinii is required."; }
    if (empty($cateplc)) { $errors[] = "Cateplc is required."; }

    if (empty($errors)) {
        
        $tableobject->keyid_clienti = $keyid_clienti; 
        $tableobject->keyid_versiuni = $keyid_versiuni; 
        
        $tableobject->numeserver = $numeserver; 
        $tableobject->datalimita = $datalimita; 
        $tableobject->frecventaheartbeat = $frecventaheartbeat; 
        $tableobject->ultimulheartbeat = $ultimulheartbeat; 
        $tableobject->catelinii = $catelinii; 
        $tableobject->cateplc = $cateplc;

    }

    $error_message = implode("\\n", $errors);

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
        <form id="createForm" method="POST" action="create_handleform.php">
            <div class="form-group">
                <label for="keyid_clienti">Clienti</label>
                <select id="keyid_clienti" name="keyid_clienti" class="form-control">
                    <option value="0" selected></option>
                    <?php 
                    while ($row_clienti = $stmt_clienti->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row_clienti['keyid'] == $keyid_clienti) ? 'selected' : '';
                        echo '<option value="' . $row_clienti['keyid'] . '" ' . $selected . '>' . $row_clienti['nume'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="keyid_versiuni">Versiuni</label>
                <select id="keyid_versiuni" name="keyid_versiuni" class="form-control">
                    <option value="0" selected></option>
                    <?php 
                    while ($row_versiuni = $stmt_versiuni->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($row_versiuni['keyid'] == $keyid_versiuni) ? 'selected' : '';
                        echo '<option value="' . $row_versiuni['keyid'] . '" ' . $selected . '>' . $row_versiuni['numar'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="numeserver">Nume Server</label>
                <input type="text" id="numeserver" name="numeserver" class="form-control" value="<?php echo htmlspecialchars($numeserver); ?>">
            </div>
            <div class="form-group">
                <label for="datalimita">Data Limita</label>
                <input type="date" id="datalimita" name="datalimita" class="form-control" value="<?php echo htmlspecialchars($datalimita); ?>">
            </div>
            <div class="form-group">
                <label for="frecventaheartbeat">Frecventa Heartbeat</label>
                <input type="number" id="frecventaheartbeat" name="frecventaheartbeat" class="form-control" value="<?php echo htmlspecialchars($frecventaheartbeat); ?>">
            </div>
            <div class="form-group">
                <label for="ultimulheartbeat">Ultimul Heartbeat</label>
                <input type="date" id="ultimulheartbeat" name="ultimulheartbeat" class="form-control" value="<?php echo htmlspecialchars($ultimulheartbeat); ?>">
            </div>
            <div class="form-group">
                <label for="catelinii">Cate Linii</label>
                <input type="number" id="catelinii" name="catelinii" class="form-control" value="<?php echo htmlspecialchars($catelinii); ?>">
            </div>
            <div class="form-group">
                <label for="cateplc">Cate PLC</label>
                <input type="number" id="cateplc" name="cateplc" class="form-control" value="<?php echo htmlspecialchars($cateplc); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        document.getElementById('createForm').onsubmit = function(event) {
            if (!validateForm(event)) {
                event.preventDefault(); // Stop form submission if validation fails
                return false;
            }
            return true;
        };

        function validateForm(event) {
            let errors = [];

            let keyid_clienti = document.getElementById("keyid_clienti").value.trim();
            let keyid_versiuni = document.getElementById("keyid_versiuni").value.trim();
            let numeserver = document.getElementById("numeserver").value.trim();
            let datalimita = document.getElementById("datalimita").value.trim();
            let frecventaheartbeat = document.getElementById("frecventaheartbeat").value;
            let ultimulheartbeat = document.getElementById("ultimulheartbeat").value.trim();
            let catelinii = document.getElementById("catelinii").value;
            let cateplc = document.getElementById("cateplc").value;

            if (keyid_clienti === "0") {errors.push("Clienti is required.");}
            if (keyid_versiuni === "0") { errors.push("Versiuni is required."); }
            if (numeserver === "") { errors.push("Nume Server is required."); }
            if (datalimita === "") { errors.push("Data Limita is required."); }
            if (frecventaheartbeat === "0") { errors.push("Frecventa Heartbeat is required."); }
            if (ultimulheartbeat === "") { errors.push("Ultimul Heartbeat is required."); }
            if (catelinii === "0") { errors.push("Cate Linii is required."); }
            if (cateplc === "0") { errors.push("Cate PLC is required."); }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }

            return true;
        }
    </script>

</body>
</html>