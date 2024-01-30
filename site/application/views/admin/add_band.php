<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 mx-auto">
            <div class="card card-dark-no-hover border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5">
                    <h1 class="text-center mb-5 fw-light"><i class="bi bi-music-note-list"></i> New Band <i class="bi bi-music-note-list"></i></h1>
                    <?php if($error == "err_fillall"): ?>
                        <p class="text-danger">Please fill all fields!</p>
                    <?php endif; ?>
                    <form action="<?php echo URL . 'administration/addband'?>" method="post">
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control card-dark-no-hover" id="bname" name="bandName" placeholder="">
                            <label for="bname">Band Name</label>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Add Band!">
                        <a class="btn btn-danger" href="<?php echo URL . 'administration'?>">Go Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>