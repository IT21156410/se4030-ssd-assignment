<?php

use PHPMailer\PHPMailer\PHPMailer;
use Random\RandomException;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function setFlashMessage(string $type, string $message): void
{
    $_SESSION['flash_messages'][$type] = $message;
}

function getFlashMessage(string $type): string|null
{
    if (isset($_SESSION['flash_messages'][$type])) {
        $message = $_SESSION['flash_messages'][$type];
        unset($_SESSION['flash_messages'][$type]);  // Clear message after displaying
        return $message;
    }
    return null;
}

function hasFlashMessage(string $type): bool
{
    return isset($_SESSION['flash_messages'][$type]);
}

/**
 * @return string
 * @throws RandomException
 */
function generateRandomPassword(): string
{
    $alphabet = '#abcdefghilkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    $pass = array();

    $alphaLength = strlen($alphabet) - 1;

    for ($i = 0; $i < 8; $i++) {
        $n = random_int(0, $alphaLength);

        $pass[] = $alphabet[$n];
    }

    return implode($pass);
}

function sendEMail($subject, $html, #[\SensitiveParameter] $email, $name = '', $reply = false): bool
{

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                            // Enable verbose debug output
        $mail->isSMTP();                                 // Send using SMTP
        $mail->Host = $_ENV['MAIL_HOST'];           // Set the SMTP server to send through
        $mail->SMTPAuth = true;                        // Enable SMTP authentication
        $mail->Username = $_ENV['MAIL_USERNAME'];       // SMTP username
        $mail->Password = $_ENV['MAIL_PASSWORD'];       // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = (int)($_ENV['MAIL_PORT']);           // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($email, $name);     // Add a recipient
        if ($reply) {
            $reply['name'] = !empty($reply['name']) ? $reply['name'] : '';
            $mail->addReplyTo($reply['email'], $reply['name']);
        }

        // Content
        $mail->isHTML(); // Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body = $html;

        return $mail->send();

    } catch (Exception $e) {
        setFlashMessage('error', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        //setFlashMessage('error', 'Message could not be sent.');
        return false;
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}