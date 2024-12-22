<div class="col-md-12">
    <form method="POST" action="read_all.php" id="filterForm">
        <div class="row">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="numeserver">Nume</label>
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
                    <div class="form-group col-md-3">
                        <label for="datalimita_start">Data limita from</label>
                        <input type="date" id="datalimita_start" name="datalimita_start" class="form-control" value="<?php echo $datalimita_start; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="datalimita_end">to</label>
                        <input type="date" id="datalimita_end" name="datalimita_end" class="form-control" value="<?php echo $datalimita_end; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="catelinii_start">Cate linii from</label>
                        <input type="number" id="catelinii_start" name="catelinii_start" class="form-control" value="<?php echo $catelinii_start; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="catelinii_end">to</label>
                        <input type="number" id="catelinii_end" name="catelinii_end" class="form-control" value="<?php echo $catelinii_end; ?>">
                    </div>
                </div>     
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="ultimulheartbeat_start">Ultimul heartbeat from</label>
                        <input type="date" id="ultimulheartbeat_start" name="ultimulheartbeat_start" class="form-control" value="<?php echo $ultimulheartbeat_start; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="ultimulheartbeat_end">to</label>
                        <input type="date" id="ultimulheartbeat_end" name="ultimulheartbeat_end" class="form-control" value="<?php echo $ultimulheartbeat_end; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cateplc_start">Cate PLC from</label>
                        <input type="number" id="cateplc_start" name="cateplc_start" class="form-control" value="<?php echo $cateplc_start; ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cateplc_end">to</label>
                        <input type="number" id="cateplc_end" name="cateplc_end" class="form-control" value="<?php echo $cateplc_end; ?>">
                    </div>
                </div>                            
            </div>
            <div class="col-2 d-flex flex-column justify-content-center">
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                <button type="button" class="btn btn-secondary mb-2" onclick="resetForm()">Reset</button>
            </div>
        </div> 
    </form>
</div>
