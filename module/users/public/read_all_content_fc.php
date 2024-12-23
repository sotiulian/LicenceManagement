<div class="col-md-12">
    <form method="POST" action="read_all.php" id="filterForm">
        <div class="row">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="username">User name</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="timestampend_start">Timestamp end from</label>
                        <input type="date" id="timestampend_start" name="timestampend_start" class="form-control" value="<?php echo $timestampend_start; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="timestampend_end">to</label>
                        <input type="date" id="timestampend_end" name="timestampend_end" class="form-control" value="<?php echo $timestampend_end; ?>">
                    </div>
                </div>
            </div>
            <div class="col-2 d-flex flex-column justify-content-center">
                <button type="submit" class="btn btn-primary mb-2">Filter</button>
                <button type="button" class="btn btn-secondary mb-2" onclick="resetForm()">Reset</button>
            </div>
        </div> 
    </form>
</div>
