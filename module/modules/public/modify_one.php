<?php
include '../config/db_connect.php';

include '../src/User.php';
include '../src/UsersGroups.php';

$user = new User($conn);
$usersgroups = new UsersGroups($conn);

/* cand se vine din click pe linie de tabel de modificat */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['formname']) && $_POST['formname'] === 'read_all_child_content') {
        /* daca modify_one a fost chemat prin click de pe formularul modifyusergroup din read_all_child_content, se salveaza alegerea */
        $user->keyid = $_POST['keyid_users']; // pastreaza $user->keyid pentru read_single()
        $usersgroups->keyid_users = $_POST['keyid_users'];
        $usersgroups->keyid_groups = $_POST['keyid_groups'];
        $stmt_child = $usersgroups->set_usersgroups();
    } else {
        /* initializez cu cheia de user cu care s-a intrat in fereastra din read_all */
        $user->keyid = $_POST['keyid']; // pastreaza $user->keyid pentru read_single()
        $usersgroups->keyid_users = $_POST['keyid'];
        // de keyid_groups nu este nevoie pentru ca se va seta pe forma read_all_child_content
    }

    /* citeste din baza de date care sunt legaturile deja existente intre users si groups si le incarca in $stmt_child de unde vor fi luate de forma read_all_child_content */
    $stmt_child = $usersgroups->read_usergroups(); // fetch este in while-ul din read_all_child_content.php

    /* scrie forma de modify_one */
    $stmt = $user->read_single();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user->username = $row['username'];
    $user->timestampend = $row['timestampend'];

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <?php include '../config/navbar.php'; ?>
    
    <div class="container">
        <div class="row">
        <div class="col-6">
        <h2>Modify User</h2>
        <form method="post" action="modify_handlerform.php"  onsubmit="return validateForm(event)">
            <input type="hidden" name="formname" value="modifyuserdata">
            <input type="hidden" id="keyid" name="keyid" value="<?php echo $user->keyid; ?>">
            <div class="form-group">
                <label for="username">username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="timestampend">Date of Birth:</label>
                <input type="datetime-local" class="form-control" id="timestampend" name="timestampend" value="<?php echo date('Y-m-d\TH:i', strtotime($user->timestampend)); ?>">
            </div>
            <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
            <button type="submit" name="save" class="btn btn-primary">Update</button>
        </form>       
        </div>
        <div class="col-6">
            <h2>Associate User with Groups</h2>
            <?php include 'read_all_child_content.php'; ?>
        </div>
        </div>
    </div>
    <script>
        function validateForm() {

            let keyid = document.getElementById("keyid").value.trim();
            let username = document.getElementById("username").value.trim();
            let password = document.getElementById("password").value.trim();
            let timestampend = document.getElementById("timestampend").value.trim();
            let errors = [];

            if (username === "") {
                errors.push("username is required.");
            }

            if (event.submitter && event.submitter.name === 'save') {
                if (password === "") {
                    errors.push("Password is required.");
                } else if (password.length < 6) {
                    errors.push("Password must be at least 6 characters long.");
                }
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
