<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo isset($_SESSION['app_name']) ? $_SESSION['app_name'] : 'App name unknown'; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../config/navbar.php'; ?>
    <div class="container">
        <h1>Program management module</h1>
    </div>
</body>
</html>
