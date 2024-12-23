<div class="col-md-12">
    <form method="POST" action="read_all.php" id="filterForm">
        <div class="row">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="numeserver">Nume server</label>
                        <input type="text" id="numeserver" name="numeserver" class="form-control" placeholder="Nume server" value="<?php echo $numeserver; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="keyid_programe">Program</label>   
                        <?php 
                        echo '<select id="keyid_programe" name="keyid_programe" class="form-control">';
                        echo '<option value="0" selected></option>'; // adding extra option with empty value to avoid setting the default value on the first record
                        while ($row_programe = $stmt_programe->fetch(PDO::FETCH_ASSOC)) {
                               $selected = ($row_programe['keyid']==$keyid_programe) ? 'selected' : '';
                               echo '<option value="' . $row_programe['keyid'] . '" ' . $selected . '>' . $row_programe['nume'] . '</option>';
                              }
                        echo '</select>';                        
                        ?>
                    </div>                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="keyid_clienti">Clienti</label>   
                        <?php 
                        echo '<select id="keyid_clienti" name="keyid_clienti" class="form-control">';
                        echo '<option value="0" selected></option>'; // adding extra option with empty value to avoid setting the default value on the first record
                        while ($row_clienti = $stmt_clienti->fetch(PDO::FETCH_ASSOC)) {
                               $selected = ($row_clienti['keyid']==$keyid_clienti) ? 'selected' : '';
                               echo '<option value="' . $row_clienti['keyid'] . '" ' . $selected . '>' . $row_clienti['nume'] . '</option>';
                              }
                        echo '</select>';                        
                        ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="keyid_versiuni">Versiuni</label>   
                        <?php 
                        echo '<select id="keyid_versiuni" name="keyid_versiuni" class="form-control">';
                        echo '<option value="0" selected></option>'; // adding extra option with empty value to avoid setting the default value on the first record
                        while ($row_versiuni = $stmt_versiuni->fetch(PDO::FETCH_ASSOC)) {
                               $selected = ($row_versiuni['keyid']==$keyid_versiuni) ? 'selected' : '';
                               echo '<option value="' . $row_versiuni['keyid'] . '" ' . $selected . '>' . $row_versiuni['numar'] . '</option>';
                              }
                        echo '</select>';                        
                        ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="dataaccess_start">Data Access Start</label>
                        <input type="date" id="dataaccess_start" name="dataaccess_start" class="form-control" value="<?php echo $dataaccess_start; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dataaccess_end">Data Access End</label>
                        <input type="date" id="dataaccess_end" name="dataaccess_end" class="form-control" value="<?php echo $dataaccess_end; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="catecalculatoare_start">Cate Calculatoare Start</label>
                        <input type="number" id="catecalculatoare_start" name="catecalculatoare_start" class="form-control" value="<?php echo $catecalculatoare_start; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="catecalculatoare_end">Cate Calculatoare End</label>
                        <input type="number" id="catecalculatoare_end" name="catecalculatoare_end" class="form-control" value="<?php echo $catecalculatoare_end; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="catestartari_start">Cate Startari Start</label>
                        <input type="number" id="catestartari_start" name="catestartari_start" class="form-control" value="<?php echo $catestartari_start; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="catestartari_end">Cate Startari End</label>
                        <input type="number" id="catestartari_end" name="catestartari_end" class="form-control" value="<?php echo $catestartari_end; ?>">
                    </div>
                </div>
            </div>
            <div class="col-2 d-flex flex-column justify-content-center">
                <button type="submit" class="btn btn-primary mt-4">Filter</button>
                <button type="button" class="btn btn-secondary mt-4" onclick="resetForm()">Reset</button>
            </div>
        </div>
    </form>
</div>