<?php

require_once __DIR__ . '/../config.php';

$clientID = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirectUri = $_ENV['GOOGLE_REDIRECT_URL'];

// Create Google Client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Redirect to Google's OAuth 2.0 server
$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
exit;
