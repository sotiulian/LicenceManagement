<?php
include '../config/db_connect.php';
include '../src/Group.php';

$tableobject = new Group($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    # Handle the case when the form is loaded from clicking in the read_all_content.php table row

    $tableobject->keyid = $_POST['keyid'];

    $stmt = $tableobject->read_single();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $tableobject->nume = $row['nume'];
    $tableobject->isadmin = $row['isadmin'];
    $tableobject->issysadmin = $row['issysadmin'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify Group</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../config/navbar.php'; ?>
    <div class="container">
        <h2>Modify Group</h2>
        <form method="post" action="modify_handlerform.php"  onsubmit="return validateForm(event)">
            <input type="hidden" name="keyid" value="<?php echo $tableobject->keyid; ?>">
            <div class="form-group">
                <label for="nume">Nume:</label>
                <input type="text" class="form-control" id="nume" name="nume" value="<?php echo $tableobject->nume; ?>">
            </div>
            <div class="form-group">
                <label for="isadmin">Is Admin:</label>
                <select id="isadmin" name="isadmin" class="form-control">
                    <option value="0" <?php echo ($tableobject->isadmin == 0 ? 'selected' : '') ?>>Not Admin</option>
                    <option value="1" <?php echo ($tableobject->isadmin == 1 ? 'selected' : '') ?>>Admin</option>
                </select>    
            </div>
            <div class="form-group">
                <label for="issysadmin">Sys Admin</label>
                <select id="issysadmin" name="issysadmin" class="form-control">
                    <option value="0" <?php echo ($tableobject->issysadmin == 0 ? 'selected' : '') ?>>Not SysAdmin</option>
                    <option value="1" <?php echo ($tableobject->issysadmin == 1 ? 'selected' : '') ?>>SysAdmin</option>
                </select>  
            </div>
            <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
            <button type="submit" name="save" class="btn btn-primary">Update</button>
        </form>       
    </div>
    <script>
        function validateForm() {

            let keyid = document.getElementById("keyid").value.trim();
            let nume = document.getElementById("nume").value.trim();
            let isadmin = document.getElementById("isadmin").value;
            let issysadmin = document.getElementById("issysadmin").value;
            let errors = [];

            if (nume === "") {
                errors.push("nume is required.");
            }

            if (event.submitter && event.submitter.name === 'save') {

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
