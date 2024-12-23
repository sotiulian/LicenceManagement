<table class="table">
    <thead>
        <tr>
            <th>Nume server</th>
            <th>Client</th>
            <th>Program</th>
            <th>Versiune</th>
            <th>Data access</th>
            <th>Cate calculatoare</th>
            <th>Cate startari</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr onclick="document.getElementById(\'form-' . $row['keyid'] . '\').submit();">';
            echo '<form id="form-' . $row['keyid'] . '" method="POST" action="modify_one.php">';
            echo '<input type="hidden" name="keyid" value="' . $row['keyid'] . '">';
            echo '<td>' . htmlspecialchars($row['numeserver']) . '</td>';
            echo '<td>' . htmlspecialchars($row['clienti_nume']) . '</td>';
            echo '<td>' . htmlspecialchars($row['program_nume']) . '</td>';
            echo '<td>' . htmlspecialchars($row['versiune_nume']) . '</td>';
            echo '<td>' . htmlspecialchars($row['dataaccess']) . '</td>';
            echo '<td>' . htmlspecialchars($row['catecalculatoare']) . '</td>';
            echo '<td>' . htmlspecialchars($row['catestartari']) . '</td>';
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
        document.getElementById("numeserver").value = "";
        document.getElementById("keyid_programe").value = 0;
        document.getElementById("keyid_clienti").value = 0;
        document.getElementById("keyid_versiuni").value = 0;
        document.getElementById("dataaccess_start").value = "<?php echo date('Y-m-01'); ?>";
        document.getElementById("dataaccess_end").value = "<?php echo date('2999-m-d'); ?>";
        document.getElementById("catecalculatoare_start").value = 0;
        document.getElementById("catecalculatoare_end").value = 9999;
        document.getElementById("catestartari_start").value = 0;
        document.getElementById("catestartari_end").value = 9999;

        document.getElementById("filterForm").submit();
    }
</script>