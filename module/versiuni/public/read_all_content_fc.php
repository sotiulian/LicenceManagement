<div class="col-md-12">
    <form method="POST" action="read_all.php" id="filterForm">
        <div class="row">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="numar">Nume</label>
                        <input type="text" id="numar" name="numar" class="form-control" placeholder="Numar" value="<?php echo $numar; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="filename">File name</label>
                        <input type="text" id="filename" name="filename" class="form-control" placeholder="Filename" value="<?php echo $filename; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="keyid_child">Program</label>   
                        <?php 
                        echo '<select id="keyid_child" name="keyid_child" class="form-control">';
                        echo '<option value="0" selected></option>'; // adding extra option with empty value to avoid setting the default value on the first record
                        while ($row_child = $stmt_child->fetch(PDO::FETCH_ASSOC)) {
                               $selected = ($row_child['keyid']==$keyid_programe) ? 'selected' : '';
                               echo '<option value="' . $row_child['keyid'] . '" ' . $selected . '>' . $row_child['nume'] . '</option>';
                              }
                        echo '</select>';                        
                        ?>
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
