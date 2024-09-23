<?php
include_once __DIR__ . '/includes/csrf_token_helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("config.php");

validateCsrfToken(); // Validate the CSRF token

if (isset($_POST['unfollow'])) {
    $user_id = $_SESSION['id'];

    $unfollow_person = $_POST['other_User_Id'];

    $get_Id = "SELECT * FROM fallowing WHERE User_Id = ? AND Other_user_id = ?;";
    $stmt = $conn->prepare($get_Id);
    $stmt->bind_param("ii", $user_id, $unfollow_person);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $target_id = $row['ID'];
    }

    $sql = "DELETE FROM fallowing WHERE ID = ?;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $target_id);

    $stmt->execute();

    $conn->close();

    update_Fallowers($unfollow_person);

    update_Fallowing($user_id);

    $_SESSION['fallowing']--;

}
header("location: home.php");


function update_Fallowing($user_id)
{
    include("config.php");

    $sql = "UPDATE users SET FALLOWING = FALLOWING-1 WHERE User_ID = ? ;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    $stmt->execute();
}

function update_Fallowers($other_Person)
{
    include("config.php");

    $sql = "UPDATE users SET FALLOWERS = FALLOWERS-1 WHERE User_ID = ?;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $other_Person);

    $stmt->execute();
}
