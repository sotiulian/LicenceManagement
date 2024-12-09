<div class="col-md-12">
    <form method="POST" action="read_all.php" id="filterForm">
        <div class="row">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nume">User name</label>
                        <input type="text" id="nume" name="nume" class="form-control" placeholder="Nume" value="<?php echo $nume; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 d-flex flex-row">
                        <label for="isadmin">Admin</label>
                        <select id="isadmin" name="isadmin" class="form-control">
                            <option value="0" <?php echo ($isadmin == 0 ? 'selected' : '') ?>>Not Admin</option>
                            <option value="1" <?php echo ($isadmin == 1 ? 'selected' : '') ?>>Admin</option>
                            <option value="2" <?php echo ($isadmin == 2 ? 'selected' : '') ?>>Admin and Not Admin</option>
                        </select>    
                    </div>
                    <div class="form-group col-md-6 d-flex flex-row">
                        <label for="issysadmin">Sys Admin</label>
                        <select id="issysadmin" name="issysadmin" class="form-control">
                            <option value="0" <?php echo ($issysadmin == 0 ? 'selected' : '') ?>>Not SysAdmin</option>
                            <option value="1" <?php echo ($issysadmin == 1 ? 'selected' : '') ?>>SysAdmin</option>
                            <option value="2" <?php echo ($issysadmin == 2 ? 'selected' : '') ?>>SysAdmin and Not SysAdmin</option>
                        </select>    
                    </div>
                </div>
            </div>
            <div class="col-2 d-flex flex-column align-items-center">
                <button type="submit" class="btn btn-primary mb-2 w-100">Submit</button>
                <button type="button" class="btn btn-secondary mb-2 w-100" onclick="resetForm()">Reset</button>
            </div>
        </div>
    </form>
</div>