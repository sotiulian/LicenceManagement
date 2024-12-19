<table class="table">
    <thead>
        <tr>
            <th>Associated</th>
            <th>Furnizori Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $stmt_child->fetch(PDO::FETCH_ASSOC)) {

            echo '<tr onclick="document.getElementById(\'form-' . $row['keyid_childs'] . '\').submit();">';
            echo '<form id="form-' . $row['keyid_childs'] . '" method="POST" action="modify_one.php">';
            echo '<input type="hidden" name="formname" value="read_all_child_content">';
            echo '<input type="hidden" name="keyid_childs" value="' . $row['keyid_childs'] . '">';
            echo '<input type="hidden" name="keyid_parent" value="' . $row['keyid_parent'] . '">';
            echo '<td>' . '<input type="checkbox" class="form-control" ' .($row['isassociated'] ? 'checked' : '') . '>' . '</td>';
            echo '<td>' . $row['nume'] . '</td>';
            echo '</form>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>