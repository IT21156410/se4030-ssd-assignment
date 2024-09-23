<?php

include('config.php');
/** @var mysqli $conn */

$user_id = $_SESSION['id'];

$sql = "SELECT * FROM fallowing WHERE User_Id = ?";

$stmt = $conn->prepare($sql);
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
    $ids[] = $user_id;
}

$ids = array_map('intval', $ids);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
//$fallowing_id = implode(",", $ids);

$sql_query_two = "SELECT * FROM Users WHERE User_Id IN({$placeholders}) AND USER_TYPE = '1' ORDER BY RAND() LIMIT 15;";

$stmt = $conn->prepare($sql_query_two);
$stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
$stmt->execute();

$Clubs = $stmt->get_result();
