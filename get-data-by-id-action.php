<?php

function get_UserData($user_id)
{
    include('config.php');
    /** @var mysqli $conn */

    $sql = "SELECT * FROM users WHERE USER_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $User_Name = $row["USER_NAME"];

            $Full_Name = $row["FULL_NAME"];

            $Profile_Picture = $row["IMAGE"];

            $data_array = array($User_Name, $Full_Name, $Profile_Picture);

            return $data_array;
        }
    } else {
        return 0;
    }

    $conn->close();

}

?>