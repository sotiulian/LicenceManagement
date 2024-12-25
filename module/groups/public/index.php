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
        <h1>Groups management module</h1>
        <!-- <p>Users management.</p> -->
    </div>
</body>
</html>