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
                                <form name="register" class="mx-1 mx-md-4" action='<?php echo REGISTER_URL; ?>' method="POST">
                                  <fieldset>
                                    <div id="legend">
                                      <legend class="">Register</legend>
                                    </div>
                                    <div class="control-group">
                                      <!-- Username -->
                                      <label class="control-label"  for="username">Username</label>
                                      <div class="controls">
                                        <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
                                          <p class="invalidFeedback">
                                              <?php echo $data['usernameError']; ?>
                                          </p>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <!-- E-mail -->
                                      <label class="control-label" for="email">E-mail</label>
                                      <div class="controls">
                                        <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
                                          <p class="invalidFeedback">
                                              <?php echo $data['emailError']; ?>
                                          </p>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <!-- Password-->
                                      <label class="control-label" for="password">Password</label>
                                      <div class="controls">
                                        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                                          <p class="invalidFeedback">
                                              <?php echo $data['passwordError']; ?>
                                          </p>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <!-- Password -->
                                      <label class="control-label"  for="confirmPassword">Password (Confirm)</label>
                                      <div class="controls">
                                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="" class="input-xlarge">
                                          <p class="invalidFeedback">
                                              <?php echo $data['confirmPasswordError']; ?>
                                          </p>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <!-- Button -->
                                      <div class="controls">
                                        <button class="btn btn-success" id="submit" type="submit" value="submit">Register</button>
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
