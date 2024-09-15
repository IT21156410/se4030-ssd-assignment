<?php


function initializeUserSession($userData, $isSignup = false): void
{
    // Set session variables from user data
    $_SESSION['id'] = $userData['User_ID'];
    $_SESSION['username'] = $userData['USER_NAME'];
    $_SESSION['fullname'] = $userData['FULL_NAME'];
    $_SESSION['email'] = $userData['EMAIL'];
    $_SESSION['usertype'] = $userData['USER_TYPE'];
    $_SESSION['facebook'] = $userData['FACEBOOK'];
    $_SESSION['whatsapp'] = $userData['WHATSAPP'];
    $_SESSION['bio'] = $userData['BIO'];
    $_SESSION['fallowers'] = $userData['FALLOWERS'];
    $_SESSION['fallowing'] = $userData['FALLOWING'];
    $_SESSION['postcount'] = $userData['POSTS'];
    $_SESSION['img_path'] = $userData['IMAGE'];

}

function authenticateUser(#[SensitiveParameter] $email, #[SensitiveParameter] $password = null, $isSignupOrSocialLogin = false): bool
{
    /** @var mysqli $conn */
    include __DIR__ . "/../config.php";

    // Fetch only the password hash for verification
    $sqlPasswordCheck = "SELECT User_ID, PASSWORD_S, GOOGLE_ID FROM users WHERE EMAIL = ?";
    $stmt = $conn->prepare($sqlPasswordCheck);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        setFlashMessage('error', 'Email does not exist.');
        return false;
    }

    $row = $result->fetch_assoc();

    // For login, check if the password matches first
    if (!$isSignupOrSocialLogin) {
        $passwordCheckMatch = password_verify($password, $row['PASSWORD_S']);

        if (!empty($row['GOOGLE_ID']) && !$passwordCheckMatch) {
            setFlashMessage('error', 'Please sign in using google account.');
            return false;
        }

        // Verify the password
        if (!$passwordCheckMatch) {
            setFlashMessage('error', 'Invalid password.');
            return false;
        }
    }

    // Fetch user data for session initialization
    $sqlUserData = "SELECT User_ID, FULL_NAME, USER_NAME, USER_TYPE, EMAIL, IMAGE, FACEBOOK, WHATSAPP, BIO, FALLOWERS, FALLOWING, POSTS FROM users WHERE EMAIL = ?";
    $stmt = $conn->prepare($sqlUserData);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    // Initialize the session
    initializeUserSession($userData, $isSignupOrSocialLogin);

    return true; // Successful authentication

}