<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("config.php");

$post_id = $_POST['post_id'] ?? '';

$comment = $_POST['comment'] ?? '';

$user_id = $_SESSION['id'];

$date = date("Y-m-d H:i:s");

$sql = "INSERT INTO comments_vid(VIDEO_ID, USER_ID, COMMENT, DATE) VALUES (?,?,?,?);";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $post_id, $user_id, $comment, $date);

if (!$stmt->execute()) {
    header("location: single-video.php?post_id=" . $post_id . "&error_message=Your Opinion Submission Abort");
}

exit;

