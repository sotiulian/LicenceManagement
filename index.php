<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WWP</title>
    <title><?php echo isset($_SESSION['app_name']) ? $_SESSION['app_name'] : 'App name unknown'; ?></title>
    <!-- Bootstrap CSS -->    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'config/navbar.php'; ?>
    <!-- Bootstrap JS, Popper.js, and jQuery for dropdown menues to work-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- main content -->
    <div class="container">
        <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true): ?>
            <h1>License management</h1>
            <!-- <p>Users management.</p> -->
        <?php else: ?>
            <h1>Login</h1>
            <form action="config/login_handler.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>