<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/includes/helper.php';

$DB_HOST = $_ENV['DB_HOST'];
$DB_USERNAME = $_ENV['DB_USERNAME'];
$DB_PASSWORD = $_ENV['DB_PASSWORD'];
$DB_DATABASE = $_ENV['DB_DATABASE'];
$DB_PORT = $_ENV['DB_PORT'];

$conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE, $DB_PORT);

if (!$conn) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        echo "<pre>";
        var_dump($args);
        echo "</pre>";
        exit;
    }
}
