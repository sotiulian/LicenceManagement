<?php
include '../config/db_connect.php';

include '../src/Licence.php';
include '../../clienti/src/Client.php';
include '../../versiuni/src/Versiune.php';

$tableobject = new Licence($conn);
$client = new Client($conn);
$versiune = new Versiune($conn);

/*
$errors = [];

$keyid_clienti = 0;
$keyid_versiuni = 0;
$numeserver = ''; 
$datalimita = date('2000-01-01');
$frecventaheartbeat = 0;
$ultimulheartbeat = date('2000-01-01');
$catelinii = 0;
$cateplc = 0;
*/

/* cand se vine din click pe linie de tabel de modificat */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* initializez cu cheia de parent cu care s-a intrat in fereastra din read_all */
    $tableobject->keyid = $_POST['keyid']; // pastreaza $parent->keyid pentru read_single()
    
    /* scrie forma de modify_one */
    $stmt = $tableobject->read_single();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $tableobject->keyid_clienti = $row['keyid_clienti']; 
    $tableobject->keyid_versiuni = $row['keyid_versiuni']; 
    
    $tableobject->numeserver = $row['numeserver']; 
    $tableobject->datalimita = $row['datalimita']; 
    $tableobject->frecventaheartbeat = $row['frecventaheartbeat']; 
    $tableobject->ultimulheartbeat = $row['ultimulheartbeat']; 
    $tableobject->catelinii = $row['catelinii']; 
    $tableobject->cateplc = $row['cateplc'];

    /* incarca $stmt_child cu lista de copii posibili */
    $keyid_clienti = $row['keyid_clienti'];
    $stmt_clienti = $client->read(); 

    $keyid_versiuni = $row['keyid_versiuni'];
    $stmt_versiuni = $versiune->read(); // citeste datele programelor pentru dropdown din filter criteria
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify Licence</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php include '../config/navbar.php'; ?>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Modify licence</h2>
                <form id= "modifyForm" method="post" action="modify_handlerform.php">
                    <input type="hidden" name="formname" value="modifyuserdata">
                    <input type="hidden" id="keyid" name="keyid" value="<?php echo $tableobject->keyid; ?>">
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
                        <input type="text" id="numeserver" name="numeserver" class="form-control" value="<?php echo htmlspecialchars($tableobject->numeserver); ?>">
                    </div>
                    <div class="form-group">
                        <label for="datalimita">Data Limita</label>
                        <input type="date" id="datalimita" name="datalimita" class="form-control" value="<?php echo htmlspecialchars($tableobject->datalimita); ?>">
                    </div>
                    <div class="form-group">
                        <label for="frecventaheartbeat">Frecventa Heartbeat</label>
                        <input type="number" id="frecventaheartbeat" name="frecventaheartbeat" class="form-control" value="<?php echo htmlspecialchars($tableobject->frecventaheartbeat); ?>">
                    </div>
                    <div class="form-group">
                        <label for="catelinii">Cate Linii</label>
                        <input type="number" id="catelinii" name="catelinii" class="form-control" value="<?php echo htmlspecialchars($tableobject->catelinii); ?>">
                    </div>
                    <div class="form-group">
                        <label for="cateplc">Cate PLC</label>
                        <input type="number" id="cateplc" name="cateplc" class="form-control" value="<?php echo htmlspecialchars($tableobject->cateplc); ?>">
                    </div>
                    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this parent?');">Delete</button>
                    <button type="submit" name="save" class="btn btn-primary">Update</button>
                </form>       
            </div>
        </div>
    </div>
    <script>
        document.getElementById('modifyForm').onsubmit = function(event) {
            if (event.submitter && event.submitter.name === 'save' && !validateForm(event)) {
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
            let catelinii = document.getElementById("catelinii").value;
            let cateplc = document.getElementById("cateplc").value;

            if (keyid_clienti === "0") {errors.push("Clienti is required.");}
            if (keyid_versiuni === "0") { errors.push("Versiuni is required."); }
            if (numeserver === "") { errors.push("Nume Server is required."); }
            if (datalimita === "") { errors.push("Data Limita is required."); }
            if (frecventaheartbeat === "0") { errors.push("Frecventa Heartbeat is required."); }
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
