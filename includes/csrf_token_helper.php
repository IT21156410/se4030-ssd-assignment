<?php
/* Start session if it's not already started */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate CSRF token and store in session if it doesn't already exist
 * @throws Exception
 */
function generateCsrfToken(): mixed
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Get CSRF token in a form (call this function inside the <html><form>)
 * @throws Exception
 */
function getCsrfTokenElement(): void
{
    $token = generateCsrfToken();
    echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/* Validate CSRF token on form submission */
function validateCsrfToken(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed.');
        }
    }
}
