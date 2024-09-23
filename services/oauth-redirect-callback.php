<?php

/** @var mysqli $conn */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/helper.php';
require_once __DIR__ . '/login-service.php';

$clientID = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirectUri = $_ENV['GOOGLE_REDIRECT_URL'];

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Get the Google OAuth 2.0 authorization code
if (!isset($_GET['code'])) {
    setFlashMessage('error', 'No authorization code provided.');
    header('Location: ../create-account.php');
    exit;
}

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

if (isset($token['error'])) {
    setFlashMessage('error', 'Failed to authenticate with Google.');
    header('Location: ../create-account.php');
    exit;
}

$client->setAccessToken($token['access_token']);

// Get user profile from Google
$googleService = new Google_Service_Oauth2($client);
$googleUser = $googleService->userinfo->get();

$google_id = $googleUser->id;
$email = $googleUser->email;
$full_name = $googleUser->name;
$picture = $googleUser->picture;

// Check if the user already exists in the database
$sql_query = "SELECT User_ID,GOOGLE_ID FROM users WHERE EMAIL = ?;";
$stmt = $conn->prepare($sql_query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows() > 0) {

    $stmt->bind_result($userID, $existingGoogleID);
    $stmt->fetch();

    // Update only if the Google info has changed
    if ($existingGoogleID !== $google_id) {
        $update_query = "UPDATE users SET GOOGLE_ID = ?, PROFILE_PICTURE = ? WHERE User_ID = ?;";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $google_id, $picture, $userID);
        $stmt->execute();
    }

    if (authenticateUser($email, isSignupOrSocialLogin: true)) {
        header('Location: ../home.php');  // Redirect to user dashboard
        exit;
    }
} else {
    // If user doesn't exist, create a new user
    $userName = userName();
    $generateRandomPassword = generateRandomPassword();
    $userType = 1;

    $insert_query = "INSERT INTO users (FULL_NAME, USER_NAME, USER_TYPE, PASSWORD_S, EMAIL, GOOGLE_ID, PROFILE_PICTURE) VALUES (?,?,?,?,?,?,?);";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssissss", $full_name, $userName, $userType, $generateRandomPassword, $email, $google_id, $picture);
    $stmt->execute();

    authenticateUser($email, isSignupOrSocialLogin: true);
    // Set flash message and redirect
    setFlashMessage('success', 'Account created successfully! Welcome, ' . $full_name . '!');
    header('Location: ../home.php');  // Redirect to user dashboard
    exit;
}

setFlashMessage('error', 'Action Not allowed.');
header('Location: ../create-account.php');
exit;