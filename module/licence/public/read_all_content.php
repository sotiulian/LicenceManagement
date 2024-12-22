<table class="table">
    <thead>
        <tr>
            <th>Nume server</th>
            <th>Client</th>
            <th>Program</th>
            <th>Versiune</th>
            <th>Data limita</th>
            <th>Cate linii</th>
            <th>Cate plc-uri</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr onclick="document.getElementById(\'form-' . $row['keyid'] . '\').submit();">';
            echo '<form id="form-' . $row['keyid'] . '" method="POST" action="modify_one.php">';
            echo '<input type="hidden" name="keyid" value="' . $row['keyid'] . '">';
            echo '<td>' . $row['numeserver'] . '</td>';
            echo '<td>' . $row['client'] . '</td>';    
            echo '<td>' . $row['program'] . '</td>';
            echo '<td>' . $row['versiune'] . '</td>';
            echo '<td>' . $row['datalimita'] . '</td>';
            echo '<td>' . $row['catelinii'] . '</td>';
            echo '<td>' . $row['cateplc'] . '</td>';
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
        document.getElementById("datalimita_start").value = "<?php echo date('1000-01-01'); ?>";
        document.getElementById("datalimita_end").value = "<?php echo date('2999-m-d'); ?>";
        document.getElementById("catelinii_start").value = 0;
        document.getElementById("catelinii_end").value = 9999;
        document.getElementById("ultimulheartbeat_start").value = "<?php echo date('1000-01-01'); ?>";
        document.getElementById("ultimulheartbeat_end").value = "<?php echo date('2999-m-d'); ?>";
        document.getElementById("cateplc_start").value = 0;
        document.getElementById("cateplc_end").value = 9999;

        document.getElementById("filterForm").submit();
    }
</script>