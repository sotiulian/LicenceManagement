<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_SESSION['app_name']) ? $_SESSION['app_name'] : 'App name unknown'; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Menu --> 
    <?php include '../config/navbar.php'; ?>

    <div class="container-fluid">
        <!-- First Row -->
        <div class="row">
            <div class="col-10">
                <h1>Program list</h1>
            </div>
            <div class="col-2 d-flex align-items-end">
                <img src="../img/program_logo.png" alt="Logo" class="img-fluid">
            </div>
        </div>
        <!-- Second Row -->
        <div class="row">
            <?php include($contentfc); ?>
        </div>
        <!-- Third Row -->
        <div class="row">
            <div class="col-10">
                <?php include($content); ?>
            </div>
            <div class="col-2 d-flex flex-column">
            <button class="btn btn-info mb-2" onclick="window.location.href='create_one.php'">Create program</button>
            </div>            
        </div>
        <!-- Fourth Row -->
        <div class="row">
            <div class="col-5">
                <p>No. of programs: <span id="sumField1"><?php echo $admin_sum; ?></span></p>
            </div>
        </div>
        <!-- Fifth Row -->
        <div class="row">
            <div class="col-10">
                <!-- <textarea class="form-control" rows="3" placeholder="Messages"></textarea> -->
                <textarea class="form-control" rows="3" placeholder="Messages"><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; unset($_SESSION['message']); ?></textarea>
            </div>
            <div class="col-2  d-flex flex-column">
                <button class="btn btn-success" onclick="window.print()">Print</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>