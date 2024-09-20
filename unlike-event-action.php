<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("config.php");

$post_id = $_POST['post_id'] ?? '';

$user_id = $_SESSION['id'];

$get_Id = "SELECT * FROM likes_events WHERE User_ID = ? AND Event_ID = ?;";
$stmt = $conn->prepare($get_Id);
$stmt->bind_param("ii", $user_id, $post_id);
$stmt->execute();
$result = $stmt->get_result();


while ($row = $result->fetch_assoc()) {
    $Like_ID = $row['Like_ID'];
}

$SQL = "DELETE FROM likes_events WHERE Like_ID = ?;";

$stmt = $conn->prepare($SQL);
$stmt->bind_param("i", $Like_ID);

$stmt->execute();

$conn->close();

update_likes($post_id);


function update_likes($post_id)
{
    include("config.php");

    $sql = "UPDATE events SET Likes = Likes-1 WHERE Event_ID = ?;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    $stmt->execute();
}

