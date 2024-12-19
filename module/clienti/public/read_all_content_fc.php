<div class="col-md-12">
    <form method="POST" action="read_all.php" id="filterForm">
        <div class="row">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nume">Clienti nume</label>
                        <input type="text" id="nume" name="nume" class="form-control" placeholder="Nume" value="<?php echo $nume; ?>">
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
