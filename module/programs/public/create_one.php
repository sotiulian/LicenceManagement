<?php
include '../config/db_connect.php';
include '../src/Program.php';

$errors = [];
$nume = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nume = trim($_POST['nume']);

    if (empty($nume)) {
        $errors[] = "Nume is required.";
    }

    if (empty($errors)) {

        $group = new Program($conn);
        
        $group->nume = $nume;

        if ($group->create()) {
            header("Location: create_one.php");
            exit();
        } else {
            $errors[] = "Failed to create group.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php include '../config/navbar.php'; ?>
    
    <div class="container">
        <h2>Create User</h2>
        <form method="POST" action="create_one.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Nume</label>
                <input type="text" id="nume" name="nume" class="form-control" value="<?php echo htmlspecialchars($nume); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        function validateForm() {
            
            let nume = document.getElementById("nume").value.trim();
            
            let errors = [];

            if (nume === "") {
                errors.push("Nume is required.");
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