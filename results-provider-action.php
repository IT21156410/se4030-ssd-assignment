<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function find_Users($search_input)
{
    include "config.php";

    $SQL = "SELECT * FROM users WHERE FULL_NAME LIKE ? OR USER_NAME LIKE ?;";

    $stmt = $conn->prepare($SQL);
    $search_string = "%{$search_input}%";
    $stmt->bind_param("ss", $search_string, $search_string);

    $stmt->execute();

    $users = $stmt->get_result();

    return $users;
}

function find_Events($search_input)
{
    include "config.php";

    $SQL = "SELECT * FROM events WHERE Caption LIKE ? OR HashTags LIKE ?;";

    $stmt = $conn->prepare($SQL);
    $search_string = "%{$search_input}%";
    $stmt->bind_param("ss", $search_string, $search_string);

    $stmt->execute();

    $event = $stmt->get_result();

    return $event;
}

function find_Shorts($search_input)
{
    include "config.php";

    $SQL = "SELECT * FROM videos WHERE CAPTION LIKE ? OR HashTags LIKE ?;";

    $stmt = $conn->prepare($SQL);
    $search_string = "%{$search_input}%";
    $stmt->bind_param("ss", $search_string, $search_string);

    $stmt->execute();

    $shorts = $stmt->get_result();

    return $shorts;
}

function get_My_Followers()
{
    include "config.php";

    $my_id = $_SESSION['id'];

    $SQL = "SELECT * FROM fallowing WHERE Other_user_id = ?;";

    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("i", $my_id);

    $stmt->execute();

    $users = $stmt->get_result();

    return $users;
}

function get_My_Followings()
{
    include "config.php";

    $my_id = $_SESSION['id'];

    $SQL = "SELECT * FROM fallowing WHERE User_Id = ?;";

    $stmt = $conn->prepare($SQL);
    $stmt->bind_param("i", $my_id);

    $stmt->execute();

    $users = $stmt->get_result();

    return $users;
}






