<?php
include __DIR__ . '../../Helpers/header.php';
include __DIR__ . '../../Helpers/navigation.php';
?>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <form name="register" class="mx-1 mx-md-4" action='<?php echo REGISTER_URL; ?>'
                                          method="POST">
                                        <fieldset>
                                            <div id="legend">
                                                <h2 class="text-center">Register</h2>
                                            </div>
                                            <div class="control-group">
                                                <!-- Username -->
                                                <label class="form-label" for="username"></label>
                                                <div class="controls">
                                                    <input type="text" id="username" name="username" class="form-control form-control-lg
                                                        <?php
                                                            if (!empty($data['usernameError'])) {
                                                                echo ' is-invalid" placeholder="' . $data['usernameError'];
                                                            } else {
                                                                echo '" placeholder="Username';
                                                            }
                                                        ?>
                                                    ">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <!-- E-mail -->
                                                <label class="form-label" for="email"></label>
                                                <div class="controls">
                                                    <input type="text" id="email" name="email" class="form-control form-control-lg
                                                        <?php
                                                            if (!empty($data['emailError'])) {
                                                                echo ' is-invalid" placeholder="' . $data['emailError'];
                                                            } else {
                                                                echo '" placeholder="E-mail';
                                                            }
                                                        ?>
                                                    ">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <!-- Password-->
                                                <label class="form-label" for="password"></label>
                                                <div class="controls">
                                                    <input type="password" id="password" name="password" class="form-control form-control-lg
                                                        <?php
                                                            if (!empty($data['passwordError'])) {
                                                                echo ' is-invalid" placeholder="' . $data['passwordError'];
                                                            } else {
                                                                echo '" placeholder="Password';
                                                            }
                                                        ?>
                                                    ">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <!-- Password -->
                                                <label class="form-label" for="confirmPassword"></label>
                                                <div class="controls">
                                                    <input type="password" id="confirmPassword" name="confirmPassword"
                                                        class="form-control form-control-lg
                                                            <?php
                                                                if (!empty($data['confirmPasswordError'])) {
                                                                    echo ' is-invalid" placeholder="' . $data['confirmPasswordError'];
                                                                } else {
                                                                    echo '" placeholder="Confirm Password';
                                                                }
                                                            ?>
                                                    ">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <!-- Button -->
                                                <div class="controls mt-2">
                                                    <button class="btn btn-success" id="submit" type="submit" value="submit">Register
                                                    </button>
                                                    <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="http://localhost/users/login" class="link-danger">Sign in</a></p>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.png" class="img-fluid" alt="Sample image">
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
