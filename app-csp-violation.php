<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed!');
}

$rawData = file_get_contents('php://input');

try {
    $data = json_decode($rawData, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    exit('JSON Decode Exception!');
}

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    exit('Invalid JSON!');
}

// Process the CSP violation report (log it to a file or database)
$logDir = __DIR__ . '/logs';
$logFile = $logDir . '/csp-violation-log.txt';

// Ensure the log directory exists and is writable
if (!is_dir($logDir) || !is_writable($logDir)) {
    http_response_code(500);
    exit('Log directory is not writable!');
}

$logEntry = sprintf(
    "[%s] CSP Violation Report: %s\n\n",
    date('Y-m-d H:i:s'),
    print_r($data, true)
);

file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

http_response_code(204);
exit('Report received!');
