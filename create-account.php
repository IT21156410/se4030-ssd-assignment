<?php
require_once __DIR__ . '/includes/helper.php';
include_once __DIR__ . '/includes/csrf_token_helper.php';
?>
<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8"/>

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <meta http-equiv="x-ua-compatible" content="ie=edge"/>

        <title>EventsWave</title>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"/>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"/>

        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-login-form.min.css"/>

    </head>

    <body>

        <section class="vh-100" style="background-image: url('assets/images/login_request/cover.png');">

            <div class="container py-5 h-100">

                <div class="row d-flex justify-content-center align-items-center h-100">

                    <div class="col col-xl-10">

                        <div class="card" style="border-radius: 1rem;">

                            <div class="row g-0">

                                <div class="col-md-6 col-lg-5 d-none d-md-block">

                                    <img src="assets/images/login_request/signup_img.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;"/>

                                </div>

                                <div class="col-md-6 col-lg-7 d-flex align-items-center">

                                    <div class="card-body p-4 p-lg-5 text-black">

                                        <form method="post" id="signup_form" action="signup_process.php">

                                            <div class="d-flex justify-content-center">

                                                <img class="mb-4" src="assets/images/login_request/small_logo.png" alt="" height="45">

                                            </div>

                                            <h6 style="text-transform: uppercase; color: grey;" class="mt-2 mb-1"><b>Join With Us</b></h6>
                                            <?php if (hasFlashMessage('error')): ?>
                                                <p id="error_message" class="text-center alert-danger">
                                                    <?php echo getFlashMessage('error'); ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if (hasFlashMessage('success')): ?>
                                                <p id="success_message" class="text-center alert-success">
                                                    <?php echo getFlashMessage('success'); ?>
                                                </p>
                                            <?php endif; ?>
                                            <div class="form-outline mb-2">

                                                <input type="text" id="full_name" class="form-control form-control-lg" name="full_name"/>

                                                <label class="form-label" for="full_name">Full Name</label>

                                            </div>

                                            <div class="form-outline mb-2">

                                                <input type="email" id="email" class="form-control form-control-lg" name="email"/>

                                                <label class="form-label" for="email">Email address</label>

                                            </div>

                                            <div class="form-outline mb-2">

                                                <input type="password" id="password" value="12345678" class="form-control form-control-lg" name="password" autocomplete="new-password"/>

                                                <label class="form-label" for="password">Password</label>

                                            </div>

                                            <div class="form-outline mb-2">

                                                <input type="password" id="confirm_password" value="12345678" class="form-control form-control-lg" name="confirm_password" autocomplete="new-password"/>

                                                <label class="form-label" for="confirm_password">Confirm Password</label>

                                            </div>

                                            <?php getCsrfTokenElement(); // Include CSRF token as hidden input ?>

                                            <div class="pt-1 mb-4 mt-2">

                                                <button class="btn btn-dark btn-lg btn-block" type="submit" name="signup_btn">SIGNUP</button>

                                            </div>

                                            <p class="mb-4 pb-lg-2" style="color: #19afd4;">Have an account?
                                                <a href="login.php" style="color: #2696ca;">

                                                    SignIn
                                                </a>
                                            </p>
                                            <hr>
                                            <div class="text-center mb-1">OR</div>
                                            <div class="d-flex justify-content-center mb-4">
                                                <a type="button" href="services/google-service.php" class="bg-white border btn-rounded px-4 py-2 text-dark">
                                                    <img src="https://lh3.googleusercontent.com/COxitqgJr1sJnIDe8-jiKhxDx1FrYbtRHKJ9z_hELisAlapwE9LUPh6fcXIfb5vwpbMl4xl9H9TRFPc5NOO8Sb3VSgIBrfRYvW6cUA" class="me-2" alt="google" style="width: 24px;">
                                                    Continue With Google
                                                </a>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script type="text/javascript" src="assets/js/mdb.min.js"></script>

    </body>

</html>
