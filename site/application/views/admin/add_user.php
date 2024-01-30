<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 mx-auto">
            <div class="card card-dark-no-hover border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5">
                    <h1 class="text-center mb-5 fw-light"><i class="bi bi-music-note-list"></i> New User <i class="bi bi-music-note-list"></i></h1>
                    <?php if($error == "err_fillall"): ?>
                        <p class="text-danger">Please fill all fields!</p>
                    <?php endif; ?>
                    <form action="<?php echo URL . 'administration/adduser'?>" method="post">
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control card-dark-no-hover" name="userName" placeholder="">
                            <label>Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input required type="text" class="form-control card-dark-no-hover" name="userSurname" placeholder="">
                            <label>Surname</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input required type="email" class="form-control card-dark-no-hover" name="userEmail" placeholder="">
                            <label>Email</label>
                        </div>
                        <label>User Auth Level</label>
                        <select class="form-select card-dark" name="userIsAdmin">
                            <option value="0">🟢Normal User</option>
                            <option value="1">🟠Administrator</option>
                        </select>
                        <br>
                        <p style="color: #ff5959 !important">
                            WARNING: The user MUST login with the following password before change their password:
                            <br><b>
                                <?php echo FIRST_LOGIN_SECURE_PW?></b>
                        </p>
                        <input class="btn btn-primary" type="submit" value="Add User!">
                        <a class="btn btn-danger" href="<?php echo URL . 'administration'?>">Go Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>