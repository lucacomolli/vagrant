<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-dark-no-hover border-0 shadow rounded-3 my-5">
                <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
                    <form method="post" action="<?php echo URL . 'account/auth'?>">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control card-dark-no-hover" id="floatingInput" name="username" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control card-dark-no-hover" id="floatingPassword" name="password" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-dark btn-login text-uppercase fw-bold" type="submit">Sign
                                in</button>
                        </div>
                        <hr class="my-4">
                        <?php if($error_code == "err_creds"):?>
                            <p style="color: #ff3f3f !important">Invalid username or password</p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>