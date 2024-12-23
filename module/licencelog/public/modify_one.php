<?php
include '../config/db_connect.php';

include '../src/Licence_log.php';
include '../../clienti/src/Client.php';
include '../../versiuni/src/Versiune.php';

$tableobject = new Licence_log($conn);
$client = new Client($conn);
$versiune = new Versiune($conn);

/* cand se vine din click pe linie de tabel de modificat */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* initializez cu cheia de parent cu care s-a intrat in fereastra din read_all */
    $tableobject->keyid = $_POST['keyid']; // pastreaza $parent->keyid pentru read_single()
    
    /* scrie forma de modify_one */
    $stmt = $tableobject->read_single();
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $tableobject->keyid_licence = $row['keyid_licence']; 

    $tableobject->numeserver = $row['numeserver']; 
    $tableobject->program_nume = $row['program_nume']; 
    $tableobject->versiune_nume = $row['versiune_nume']; 
    $tableobject->clienti_nume = $row['clienti_nume']; 
    $tableobject->dataaccess = $row['dataaccess'];
    $tableobject->catecalculatoare = $row['catecalculatoare'];
    $tableobject->catestartari = $row['catestartari'];
    $tableobject->catelinii = $row['catelinii']; 
    $tableobject->cateplc = $row['cateplc'];
    $tableobject->catioperatori = $row['catioperatori'];
    $tableobject->catetablete = $row['catetablete'];
    $tableobject->eroriprogram = $row['eroriprogram'];
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
                <h2>Show licence log</h2>
                <form id= "modifyForm" method="post" action="modify_handlerform.php">
                    <input type="hidden" name="formname" value="modifyuserdata">
                    <input type="hidden" id="keyid" name="keyid" value="<?php echo $tableobject->keyid; ?>">
                    <div class="form-group">
                        <label for="numeserver">Nume Server</label>
                        <input type="text" id="numeserver" name="numeserver" class="form-control" value="<?php echo htmlspecialchars($tableobject->numeserver); ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="program_nume">Program</label>
                            <input type="text" id="program_nume" name="program_nume" class="form-control" value="<?php echo htmlspecialchars($tableobject->program_nume); ?>">
                        </div>                    
                        <div class="form-group col-md-4">
                            <label for="versiune_nume">Versiune</label>
                            <input type="text" id="versiune_nume" name="versiune_nume" class="form-control" value="<?php echo htmlspecialchars($tableobject->versiune_nume); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="clienti_nume">Client</label>
                            <input type="text" id="clienti_nume" name="clienti_nume" class="form-control" value="<?php echo htmlspecialchars($tableobject->clienti_nume); ?>">
                        </div> 
                    </div>
                    <div class="form-row">                 
                        <div class="form-group col-md-4">
                            <label for="dataaccess">Data acces</label>
                            <input type="date" id="dataaccess" name="dataaccess" class="form-control" value="<?php echo htmlspecialchars($tableobject->dataaccess); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="catecalculatoare">Cate calculatoare</label>
                            <input type="number" id="catecalculatoare" name="catecalculatoare" class="form-control" value="<?php echo htmlspecialchars($tableobject->catecalculatoare); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="catestartari">Cate startari</label>
                            <input type="number" id="catestartari" name="catestartari" class="form-control" value="<?php echo htmlspecialchars($tableobject->catestartari); ?>">
                        </div>                
                    </div>    
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="catelinii">Cate Linii</label>
                            <input type="number" id="catelinii" name="catelinii" class="form-control" value="<?php echo htmlspecialchars($tableobject->catelinii); ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cateplc">Cate PLC</label>
                            <input type="number" id="cateplc" name="cateplc" class="form-control" value="<?php echo htmlspecialchars($tableobject->cateplc); ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="catioperatori">Cati operatori</label>
                            <input type="number" id="catioperatori" name="catioperatori" class="form-control" value="<?php echo htmlspecialchars($tableobject->catioperatori); ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="catetablete">Cate tablete</label>
                            <input type="number" id="catetablete" name="catetablete" class="form-control" value="<?php echo htmlspecialchars($tableobject->catetablete); ?>">
                        </div>                
                    </div>    
                    <!-- <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this parent?');">Delete</button> -->
                    <button type="submit" name="save" class="btn btn-primary">Close</button>
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
            /* this data are read only, no need to validate
            let numeserver = document.getElementById("numeserver").value.trim();
            let program_nume = document.getElementById("program_nume").value.trim();
            let versiune_nume = document.getElementById("versiune_nume").value.trim();
            let clienti_nume = document.getElementById("clienti_nume").value.trim();
            let dataaccess = document.getElementById("dataaccess").value.trim();
            let catecalculatoare = document.getElementById("catecalculatoare").value;
            let catestartari = document.getElementById("catestartari").value;
            let catelinii = document.getElementById("catelinii").value;
            let cateplc = document.getElementById("cateplc").value;
            let catioperatori = document.getElementById("catioperatori").value;
            let catetablete = document.getElementById("catetablete").value;

            if (numeserver === "") { errors.push("Nume Server is required."); }
            if (program_nume === "") { errors.push("Program Nume is required."); }
            if (versiune_nume === "") { errors.push("Versiune Nume is required."); }
            if (clienti_nume === "") { errors.push("Clienti Nume is required."); }
            if (dataaccess === "") { errors.push("Data Access is required."); }
            if (catecalculatoare === "0") { errors.push("Cate Calculatoare is required."); }
            if (catestartari === "0") { errors.push("Cate Startari is required."); }
            if (catelinii === "0") { errors.push("Cate Linii is required."); }
            if (cateplc === "0") { errors.push("Cate PLC is required."); }
            if (catioperatori === "0") { errors.push("Cati Operatori is required."); }
            if (catetablete === "0") { errors.push("Cate Tablete is required."); }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }
            */
            return true;
        }
    </script>

</body>
</html>
