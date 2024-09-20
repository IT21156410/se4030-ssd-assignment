<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("config.php");

validateCsrfToken(); // Validate the CSRF token

if (isset($_POST['change-password'])) {
    $user_id = $_SESSION['id'];

    $current_password = get_CurrentPassword($user_id);

    $old_password = $_POST['old-password'];

    $new_password = $_POST['new-password'];

    $retype_password = $_POST['retype-password'];

    //if (strcmp($current_password, md5($data_By_User)) === 0) {
    if (password_verify($old_password, $current_password)) {
        if (password_verify($new_password, $current_password)) {
            header('location: edit-profile.php?error_message=You Can"t Use Old Password as your new password');
            exit();
        }

        if (strcmp($new_password, $retype_password) === 0) {
            Update_Password($new_password, $user_id);
        } else {
            header('location: edit-profile.php?error_message=Retype Correctly New Password');
            exit();
        }
    } else {
        header('location: edit-profile.php?error_message=Old Password You Entered Incorrect');
        exit();
    }

}

function Update_Password(#[SensitiveParameter] $new_password, $user_id)
{
    include 'config.php';

    $secure_password = password_hash($new_password, PASSWORD_DEFAULT);

    $SQL = "UPDATE users SET PASSWORD_S = ? WHERE User_ID = ?";

    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("si", $secure_password, $user_id);
    if ($stmt->execute()) {
        header('location: edit-profile.php?success_message=Password Change Successfully');
        exit;
    } else {
        header('location: edit-profile.php?error_message=Problem With Password Change Process');
        exit();
    }

}

function get_CurrentPassword($User_ID)
{
    include 'config.php';

    $SQL = "SELECT * FROM users WHERE User_ID = ?";
    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("i", $User_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $password = $row["PASSWORD_S"];

            return $password;
        }
    } else {
        return 0;
    }

    $conn->close();
}
