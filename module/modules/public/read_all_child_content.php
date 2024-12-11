<table class="table">
    <thead>
        <tr>
            <th>Associated</th>
            <th>Group Name</th>
            <th>Is Admin</th>
            <th>Is SysAdmin</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $stmt_child->fetch(PDO::FETCH_ASSOC)) {

            echo '<tr onclick="document.getElementById(\'form-' . $row['keyid_groups'] . '\').submit();">';
            echo '<form id="form-' . $row['keyid_groups'] . '" method="POST" action="modify_one.php">';
            echo '<input type="hidden" name="formname" value="read_all_child_content">';
            echo '<input type="hidden" name="keyid_groups" value="' . $row['keyid_groups'] . '">';
            echo '<input type="hidden" name="keyid_users" value="' . $row['keyid_users'] . '">';
            echo '<td>' . '<input type="checkbox" class="form-control" ' .($row['isassociated'] ? 'checked' : '') . '>' . '</td>';
            echo '<td>' . $row['nume'] . '</td>';
            echo '<td>' . '<input type="checkbox" class="form-control" ' .($row['isadmin'] ? 'checked' : '') . ' disabled>' . '</td>';
            echo '<td>' . '<input type="checkbox" class="form-control" '. ($row['issysadmin'] ? 'checked' : '') . ' disabled>' . '</td>';
            echo '</form>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>