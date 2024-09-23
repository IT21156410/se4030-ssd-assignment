<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php');

validateCsrfToken(); // Validate the CSRF token
$post_id = $_POST['post_id'];

if (isset($_POST['drop'])) {
    Drop_Post($post_id);
} else {
    $send = "single-post.php?post_id={$post_id}&error_message=Unrecognized Request";
    header("location: {$send}");
    exit;
}

function Drop_Post($post_id)
{
    include 'config.php';

    $SQL = "DELETE FROM posts WHERE Post_ID = ?";

    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        Drop_Likes($post_id);
        Drop_Comments($post_id);
        Drop_Count();
        header("location: home.php");
        exit;

    }

    $send = "single-post.php?post_id={$post_id}&error_message=Problem With Drop Your Post";
    header("location: {$send}");

    exit;
}

function Drop_Likes($post_id): void
{
    include 'config.php';

    $SQL = "DELETE FROM likes WHERE Post_ID = ?";
    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
}

function Drop_Comments($post_id): void
{
    include 'config.php';

    $SQL = "DELETE FROM comments WHERE POST_ID = ?";
    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
}

function Drop_Count(): void
{
    include 'config.php';
    $user_id = $_SESSION['id'];
    $SQL = "UPDATE users SET POSTS = POSTS-1 WHERE User_ID = ?;";
    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $_SESSION['postcount']--;
}
