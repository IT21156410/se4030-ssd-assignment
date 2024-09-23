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
    $invite_link = $_POST['invite-link'];
    $event_date = $_POST['event-date'];
    $event_time = $_POST['time'];
    Update_Post($post_id, $post_caption, $post_hash, $invite_link, $event_date, $event_time);
}

function Update_Post($post_id, $post_caption, #[SensitiveParameter] $post_hash, $invite_link, $event_date, $event_time)
{
    include 'config.php';

    $SQL = "UPDATE events SET Caption = ?, HashTags = ?, Event_Time = ?, Invite_Link = ?, Event_Date = ? WHERE Event_ID = ?;";

    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("sssssi", $post_caption, $post_hash, $event_time, $invite_link, $event_date, $post_id);

    if ($stmt->execute()) {
        $send = "single-event.php?post_id={$post_id}&success_message=Current Post Updated Successfully";
        header("location: {$send}");
        exit;
    }

    $send = "single-event.php?post_id={$post_id}&error_message=Problem With Post Update";
    header("location: {$send}");
    exit;
}
