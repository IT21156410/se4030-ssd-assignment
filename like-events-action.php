<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("config.php");

$post_id = $_POST['post_id'] ?? '';

$user_id = $_SESSION['id'];

$SQL = "INSERT INTO likes_events(Event_ID, User_ID)VALUES(?, ?);";

$stmt = $conn->prepare($SQL);
$stmt->bind_param("ii", $post_id, $user_id);

$stmt->execute();

$conn->close();

update_likes($post_id);


function update_likes($post_id)
{
    include("config.php");

    $sql = "UPDATE events SET Likes = Likes+1 WHERE Event_ID = ?;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    $stmt->execute();
}

