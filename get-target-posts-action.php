<?php

include('config.php');

$ID = $target_id;

$sql = "SELECT * FROM Posts WHERE User_ID = ? ORDER BY Post_ID DESC;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ID);

if ($stmt->execute()) {
    $posts = $stmt->get_result();
} else {
    $posts = [];
}
