<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php');
include('services/login-service.php');

validateCsrfToken(); // Validate the CSRF token

if (isset($_POST['button'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!authenticateUser($email, $password)) {
        header('Location: login.php');
        exit;
    }

    setFlashMessage('success', 'Login successfully!.');
    header("location: home.php");
    exit;
}

setFlashMessage('error', 'Action not allowed.');
header('location: login.php');
exit;
