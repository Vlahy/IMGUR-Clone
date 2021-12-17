<?php
include __DIR__ . '../../Helpers/header.php';
?>

    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <form name="login" class="mx-1 mx-md-4" action="<?php echo LOGIN_URL; ?>"
                                          method="POST">
                                        <fieldset>
                                            <div id="legend" class="mb-5">
                                                <h2 class="text-center">Login</h2>
                                            </div>
                                            <!-- Email input -->
                                            <div class="control-group">
                                                <label class="form-label" for="email"></label>
                                                <div class="controls">
                                                    <input type="email" id="email" name="email" class="form-control form-control-lg
                                                        <?php
                                                            if (!empty($data['emailError'])) {
                                                                echo ' is-invalid" placeholder="' . $data['emailError'];
                                                            } else {
                                                                echo '" placeholder="Email';
                                                            }
                                                        ?>"
                                                           placeholder="Enter a valid email address"/>
                                                </div>
                                            </div>

                                            <!-- Password input -->
                                            <div class="form-outline mb-3">
                                                <label class="form-label" for="password"></label>
                                                <div class="controls">
                                                    <input type="password" id="password" name="password" class="form-control form-control-lg
                                                        <?php
                                                            if (!empty($data['passwordError'])) {
                                                                echo ' is-invalid" placeholder="' . $data['passwordError'];
                                                            } else {
                                                                echo '" placeholder="Enter password';
                                                            }
                                                        ?>
                                                    "/>
                                                </div>
                                                <?php
                                                    if (!empty($data['submitError'])) {
                                                        echo '<div class="alert alert-danger" role="alert"><p>' . $data['submitError'] . '</p></div>';
                                                    }
                                                ?>
                                            </div>

                                            <div class="text-center text-lg-start mt-4 pt-2">
                                                <button class="btn btn-success" id="submit" type="submit"
                                                        value="submit">Login
                                                </button>
                                                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a
                                                            href="http://localhost/users/register"
                                                            class="link-danger">Register</a></p>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.png"
                                         class="img-fluid"
                                         alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php

include __DIR__ . '../../Helpers/footer.php';
