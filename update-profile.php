<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

require 'init.php';

session_regenerate_id(true);

include('config.php');

include('functions.php');

validateCsrfToken(); // Validate the CSRF token

if (isset($_POST['submit'])) {
    $ID = $_SESSION['id'];
    $full_name = $_POST['full_name'];
    $user_name = $_POST['user_name'];
    $email_address = $_POST['email'];
    $facebook = $_POST['fbook'];
    $whatsapp = $_POST['wapp'];
    $bio = $_POST['bio'];

    $image = $_FILES['image']['temp_name'];

    if ($image !== "") {
        $image_name = $user_name . ".jpg";
    } else {
        $image_name = $_SESSION['img_path'];
    }

    if ($user_name !== $_SESSION['username']) {
        $sql_query = "SELECT USER_NAME FROM USERS WHERE USER_NAME = ?;";

        $stmt = $conn->prepare($sql_query);
        $stmt->bind_param("s", $user_name);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows() > 0) {
            header('location: edit-profile.php?error_message=User Name Already Taken');
            exit;
        }
    }
    Update_Profile($ID, $full_name, $user_name, $email_address, $facebook, $whatsapp, $bio);

} else {
    header("location: edit-profile.php");
    exit;
}

