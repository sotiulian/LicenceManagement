
<?php
include 'config/db_connect.php';

// Fetch users and groups
$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$groups = $db->query("SELECT * FROM groups")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $group_ids = $_POST['group_ids'];

    // Delete existing relationships
    $db->prepare("DELETE FROM users_group WHERE user_id = ?")->execute([$user_id]);

    // Insert new relationships
    $stmt = $db->prepare("INSERT INTO users_group (user_id, group_id) VALUES (?, ?)");
    foreach ($group_ids as $group_id) {
        $stmt->execute([$user_id, $group_id]);
    }
}

// Fetch user-group relationships
$user_groups = $db->query("SELECT * FROM users_group")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage User Groups</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>
<body>
    <?php include 'config/navbar.php'; ?>
    <div class="container">
        <h1>Manage User Groups</h1>
        <form method="POST">
            <div class="form-group">
                <label for="user_id">Select User</label>
                <select id="user_id" name="user_id" class="form-control">
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['keyid'] ?>"><?= $user['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="group_ids">Select Groups</label>
                <select id="group_ids" name="group_ids[]" class="form-control" multiple>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= $group['keyid'] ?>"><?= $group['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</body>
</html>