<?php
include '../config/db_connect.php';
include '../src/User.php';

$user = new User($conn);

$errors = [];
$username = '';
$email = '';
$timestampend = '';
$networth = '';
$password = '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta username="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
    <?php include '../config/navbar.php'; ?>

    <div class="container">
        <h2>Create User</h2>
        <form method="POST" action="create_handleform.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">username</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="timestampend">Timestamp end</label>
                <input type="date" id="timestampend" name="timestampend" class="form-control" value="<?php echo htmlspecialchars($timestampend); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        function validateForm() {
            let username = document.getElementById("username").value.trim();
            let password = document.getElementById("password").value.trim();
            let timestampend = document.getElementById("timestampend").value.trim();
            let errors = [];

            if (username === "") {
                errors.push("username is required.");
            }

            if (password === "") {
                errors.push("Password is required.");
            } else if (password.length < 6) {
                errors.push("Password must be at least 6 characters long.");
            }

            if (timestampend === "") {
                errors.push("Timestamp end is required.");
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