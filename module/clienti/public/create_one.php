<?php
include '../config/db_connect.php';
include '../src/Client.php';

$tableobject = new Client($conn);

$errors = [];
$nume = '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta username="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Client</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
    <?php include '../config/navbar.php'; ?>

    <div class="container">
        <h2>Create User</h2>
        <form method="POST" action="create_handleform.php">
            <div class="form-group">
                <label for="nume">Client nume</label>
                <input type="text" id="nume" name="nume" class="form-control" value="<?php echo htmlspecialchars($nume); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>