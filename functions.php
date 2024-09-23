<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function Update_Profile($ID, $full_name, $user_name, $email_address, $facebook, $whatsapp, $bio)
{
    include 'config.php';

    $insert_query = "UPDATE users SET FULL_NAME = ?, USER_NAME = ? ,EMAIL = ?, FACEBOOK = ?, WHATSAPP = ?, BIO = ? WHERE User_ID = ? ;";

    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssssssi", $full_name, $user_name, $email_address, $facebook, $whatsapp, $bio, $ID);
    if ($stmt->execute()) {
        $_SESSION['id'] = $ID;
        $_SESSION['username'] = $user_name;
        $_SESSION['fullname'] = $full_name;
        $_SESSION['email'] = $email_address;
        $_SESSION['facebook'] = $facebook;
        $_SESSION['whatsapp'] = $whatsapp;
        $_SESSION['bio'] = $bio;
        header("location: my-profile.php?success_message=Profile Updated Successfully");
        exit;

    }

    header("location: edit-profile.php?error_message=error Occurred");
    exit;
}

