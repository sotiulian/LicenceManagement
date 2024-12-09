<table class="table">
    <thead>
        <tr>
            <th>keyid</th>
            <th>Username</th>
            <th>Timestamp end</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo '<tr onclick="document.getElementById(\'form-' . $row['keyid'] . '\').submit();">';
            echo '<form id="form-' . $row['keyid'] . '" method="POST" action="modify_one.php">';
            echo '<input type="hidden" name="keyid" value="' . $row['keyid'] . '">';
            echo '<td>' . $row['keyid'] . '</td>';
            echo '<td>' . $row['username'] . '</td>';
            echo '<td>' . $row['timestampend'] . '</td>';
            echo '</form>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-end">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="#" onclick="submitPage(' . $i . ')">' . $i . '</a></li>';
        }
        ?>
    </ul>
</nav>

<script>
    function submitPage(page) {
        const form = document.getElementById('filterForm');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'page';
        input.value = page;

        form.appendChild(input);
        form.submit();
    }

    function resetForm() {
        document.getElementById("username").value = "";
        document.getElementById("timestampend_start").value = "<?php echo date('1000-m-01'); ?>";
        document.getElementById("timestampend_end").value = "<?php echo date('2999-m-d'); ?>";
        
        document.getElementById("filterForm").submit();
    }
</script>