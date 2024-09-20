<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php');

validateCsrfToken(); // Validate the CSRF token

if (isset($_POST['edit-comment'])) {

    $post_id = $_POST['post_id'];
    $comment_id = $_POST['comment_id'];
    $comment = $_POST['comment'];
    Update_Comment($post_id, $comment, $comment_id);
}

function Update_Comment($post_id, $post_comment, $comment_id)
{
    include 'config.php';

    $SQL = "UPDATE comments_events SET COMMENT = ? WHERE COMMENT_ID = ?;";

    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("si", $post_comment, $post_id);

    if ($stmt->execute()) {
        $send = "single-event.php?post_id={$post_id}&success_message=Current Opinion Updated Successfully";
        header("location: {$send}");
        exit;
    }

    $send = "single-event.php?post_id={$post_id}&error_message=Problem With Update Opinion";
    header("location: {$send}");
    exit;
}
