<div class="col-md-12">
    <form method="POST" action="read_all.php" id="filterForm">
        <div class="row">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nume">Nume</label>
                        <input type="text" id="nume" name="nume" class="form-control" placeholder="Nume" value="<?php echo $nume; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="modul">Modul</label>
                        <input type="text" id="modul" name="modul" class="form-control" placeholder="Modul" value="<?php echo $modul; ?>">
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
                        <label for="issys">Sys Module</label>
                        <select id="issys" name="issys" class="form-control">
                            <option value="0" <?php echo ($issys == 0 ? 'selected' : '') ?>>Not Sys Module</option>
                            <option value="1" <?php echo ($issys == 1 ? 'selected' : '') ?>>Sys Module</option>
                            <option value="2" <?php echo ($issys == 2 ? 'selected' : '') ?>>SysModule and Not SysModule</option>
                        </select>    
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
