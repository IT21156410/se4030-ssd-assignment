<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("config.php");

validateCsrfToken(); // Validate the CSRF token

if (isset($_POST['fallow'])) {
    $user_id = $_SESSION['id'];
    $falloing_person = $_POST['fallow_person'];
    $sql = "INSERT INTO fallowing(User_ID, Other_user_id) VALUES (?, ?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $falloing_person);
    $stmt->execute();
    $conn->close();
    update_Fallowers($falloing_person);
    update_Fallowing($user_id);
    $_SESSION['fallowing']++;
}
header("location: home.php");


function update_Fallowing($user_id)
{
    include("config.php");

    $sql = "UPDATE users SET FALLOWING = FALLOWING+1 WHERE User_ID = ? ;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

function update_Fallowers($other_Person)
{
    include("config.php");

    $sql = "UPDATE users SET FALLOWERS = FALLOWERS+1 WHERE User_ID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $other_Person);
    $stmt->execute();
}
