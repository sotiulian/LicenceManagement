<?php
include '../config/db_connect.php';
include '../src/Modul.php';

$modul = new Modul($conn);

$errors = [];
$nume = '';
$modul = '';
$issys = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nume = trim($_POST['nume']);
    $modul = $_POST['modul'];
    $issys = $_POST['issys'];

    if (empty($nume)) {
        $errors[] = "Nume is required.";
    }

    if (empty($errors)) {

        $modul = new Modul($conn);
        
        $modul->nume = $nume;
        $modul->modul = $modul;
        $modul->issys = $issys;


        if ($group->create()) {
            header("Location: create_one.php");
            exit();
        } else {
            $errors[] = "Failed to create record.";
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
    <title>Create Module</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
    <?php include '../config/navbar.php'; ?>

    <div class="container">
        <h2>Create Module</h2>
        <form method="POST" action="create_handleform.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nume">Nume</label>
                <input type="text" id="nume" name="nume" class="form-control" value="<?php echo htmlspecialchars($nume); ?>">
            </div>
            <div class="form-group">
                <label for="modul">Modul</label>
                <input type="text" id="modul" name="modul" class="form-control">
            </div>
            <div class="form-group">
                <label for="issys">Is Sys Module</label>
                <input type="hidden" name="issys" value="0">
                <input type="checkbox" id="issys" name="issys" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        function validateForm() {
            let nume = document.getElementById("nume").value.trim();
            let modul = document.getElementById("modul").value.trim();

            let errors = [];

            if (nume === "") {errors.push("Nume is required.");}
            if (modul === "") {errors.push("Modul is required.");} 

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