<?php
include_once __DIR__ . '/includes/headers.php';
include_once __DIR__ . '/includes/helper.php';
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (isset($_SESSION['id'])) {
    header('location: home.php');
    exit;
}

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
        <!-- Start your project here-->
        <section class="vh-100" style="background-image: url('assets/images/login_request/cover.png');">

            <div class="container py-5 h-100">

                <div class="row d-flex justify-content-center align-items-center h-100">

                    <div class="col col-xl-10">

                        <div class="card" style="border-radius: 1rem;">

                            <div class="row g-0">

                                <div class="col-md-6 col-lg-5 d-none d-md-block">

                                    <img
                                            src="assets/images/login_request/main_img.jpg"
                                            alt="login form"
                                            class="img-fluid" style="border-radius: 1rem 0 0 1rem;"
                                    />

                                </div>

                                <div class="col-md-6 col-lg-7 d-flex align-items-center">

                                    <div class="card-body p-4 p-lg-5 text-black">

                                        <form method="post" action="login-action.php">

                                            <img src="assets/images/login_request/small_logo.png" height="40px" width="auto">
                                            <br><br>

                                            <h5 class="fw-normal mb-3 pb-3" style="text-transform: uppercase; color: grey;"><b>Sign in with your sltc id</b></h5>
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

                                            <div class="form-outline mb-4">
                                                <input type="text" id="form2Example17" class="form-control form-control-lg" name="email"/>
                                                <label class="form-label" for="form2Example17">Email address/User Name</label>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <input type="password" id="form2Example27" class="form-control form-control-lg" name="password"/>
                                                <label class="form-label" for="form2Example27">Password</label>
                                            </div>

                                            <?php getCsrfTokenElement(); // Include CSRF token as hidden input ?>

                                            <div class="pt-1 mb-4">
                                                <button class="btn btn-dark btn-lg btn-block" type="submit" name="button">Login</button>
                                            </div>

                                            <a class="small text-muted" href="reset-password.php">Forgot password?</a>

                                            <p class="mb-2 pb-lg-2" style="color: #19afd4;">Don't have an account?
                                                <a href="create-account.php" style="color: #2696ca;">Register here</a>
                                            </p>
                                            <hr>
                                            <div class="text-center mb-1">OR</div>
                                            <div class="d-flex justify-content-center mb-4">
                                                <a type="button" href="services/google-service.php" class="bg-white border btn-rounded px-4 py-2 text-dark">
                                                    <img src="https://lh3.googleusercontent.com/COxitqgJr1sJnIDe8-jiKhxDx1FrYbtRHKJ9z_hELisAlapwE9LUPh6fcXIfb5vwpbMl4xl9H9TRFPc5NOO8Sb3VSgIBrfRYvW6cUA" class="me-2" alt="google" style="width: 24px;">
                                                    Log In With Google
                                                </a>
                                            </div>

                                            <a href="#!" class="small text-muted">Terms of use.</a>

                                            <a href="#!" class="small text-muted">Privacy policy</a>

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

        <script type="text/javascript"></script>

    </body>

</html>
