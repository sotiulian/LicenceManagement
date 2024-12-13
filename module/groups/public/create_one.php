<?php
include '../config/db_connect.php';
include '../src/Group.php';

$errors = [];
$nume = '';
$isadmin = 0;
$issysadmin = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nume = trim($_POST['nume']);
    $isadmin = $_POST['isadmin'];
    $issysadmin = $_POST['issysadmin'];

    if (empty($nume)) {
        $errors[] = "Nume is required.";
    }

    if (empty($errors)) {

        $group = new Group($conn);
        
        $group->nume = $nume;
        $group->isadmin = $isadmin;
        $group->issysadmin = $issysadmin;


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
            <div class="form-group">
                <label for="isadmin">Is Admin</label>
                <input type="hidden" name="isadmin" value="0">
                <input type="checkbox" id="isadmin" name="isadmin" class="form-control">
            </div>
            <div class="form-group">
                <label for="issysadmin">Is SysAdmin</label>
                <input type="hidden" name="issysadmin" value="0">
                <input type="checkbox" id="issysadmin" name="issysadmin" class="form-control">
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