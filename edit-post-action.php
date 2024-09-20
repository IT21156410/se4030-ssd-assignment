<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php');

validateCsrfToken(); // Validate the CSRF token

if (isset($_POST['edit'])) {
    $post_id = $_POST['post_id'];

    $post_hash = $_POST['hash-tag'];

    $post_caption = $_POST['caption'];

    Update_Post($post_id, $post_caption, $post_hash);
}

function Update_Post($post_id, $post_caption, #[SensitiveParameter] $post_hash)
{
    include 'config.php';

    $SQL = "UPDATE posts SET Caption = ?, HashTags = ? WHERE Post_ID = ?;";

    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("ssi", $post_caption, $post_hash, $post_id);

    if ($stmt->execute()) {
        $send = "single-post.php?post_id={$post_id}&success_message=Current Post Updated Successfully";
        header("location: {$send}");
        exit;
    }

    $send = "single-post.php?post_id={$post_id}&error_message=Problem With Post Update";
    header("location: {$send}");
    exit;
}
