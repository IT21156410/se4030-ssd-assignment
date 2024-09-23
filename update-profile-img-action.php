<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit;
}

include('config.php');

validateCsrfToken(); // Validate the CSRF token

if (isset($_POST['posting'])) {

    $filename = $_FILES['image']['name'];
    $tempname = $_FILES["image"]["tmp_name"];
    $file_extansion = pathinfo($filename, PATHINFO_EXTENSION);
    $random_number = random_int(0, 10000000);
    $file_rename = 'Profile_' . date('Ymd') . $random_number;
    $file_complete = $file_rename . '.' . $file_extansion;
    $folder = "./assets/images/profiles/" . $file_complete;

    move_uploaded_file($tempname, $folder);

    $user_id = $_SESSION['id'];

    update_Profile($user_id, $file_complete);

    header("location: edit-profile.php?success_message=Post Successfully updated");
} else {
    header("location: edit-profile.php?error_message=Error Occurred, try again2 - ERROR #009");
}
exit;


function update_Profile($user_id, $file_name)
{
    include 'config.php';

    $insert_query = "UPDATE users SET IMAGE = ? WHERE User_ID = ? ;";

    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("si", $file_name, $user_id);

    if ($stmt->execute()) {
        $_SESSION['img_path'] = $file_name;
    }
}
