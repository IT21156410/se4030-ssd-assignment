<?php

include('config.php');

$user_id = $_SESSION['id'];

$post_id = $post['Video_ID'];

$sql = "SELECT * FROM likes_vid WHERE User_ID = ? AND Video_ID = ?;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $post_id);
$stmt->execute();

$stmt->store_result();

if ($stmt->num_rows() > 0)
{
    $reaction_status = true;
}else
{
    $reaction_status = false;
}

