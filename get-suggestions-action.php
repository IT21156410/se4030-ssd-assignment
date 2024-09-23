<?php

include("config.php");

$user_id = $_SESSION['id'];

$sql_query = "SELECT Other_user_id FROM fallowing WHERE User_Id = ?";
$stmt = $conn->prepare($sql_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$ids = array();

$result = $stmt->get_result();

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    foreach ($row as $rows) {
        $ids[] = $rows;
    }
}

if (empty($ids)) {
    $ids = [$user_id];
}

//$fallowing_id = implode(",", $ids);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql_query_two = "SELECT * FROM Users WHERE User_Id NOT IN({$placeholders}) ORDER BY RAND() LIMIT 4;";

$stmt = $conn->prepare($sql_query_two);
$stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
$stmt->execute();

$suggestions = $stmt->get_result();

