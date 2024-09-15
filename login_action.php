<?php

session_start();

include('config.php');
include('services/login-service.php');

if (isset($_POST['button'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    if (!authenticateUser($email, $password)) {
        header('Location: login.php');
        exit;
    }

    setFlashMessage('success', 'Login successfully!.');
    header("location: home.php");
}

setFlashMessage('error', 'Action not allowed.');
header('location: login.php');
exit;
