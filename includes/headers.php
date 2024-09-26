<?php

// Show All Errors
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Hide All Errors
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

/*
 * To fix the "X-Powered-By" related vulnerability,
 * need to ensure that this header is not sent in HTTP responses from the PHP application.
 * In application level, we can remove the "X-Powered-By" header. Otherwise, can do that in php.ini file.
 * */
header_remove('X-Powered-By');

/*
 * To fix the "X-Content-Type-Options Header Missing" vulnerability,
 * X-Content-Type-Options HTTP header need properly set to nosniff.
 * */
header('X-Content-Type-Options: nosniff');

/*
 * To fix the "Missing Anti-clickjacking Header" vulnerability,
 * need to add the X-Frame-Options header to prevent the pages from being embedded in an iframe.
 * */
header('X-Frame-Options: DENY');

/*
 * To fix the "Content Security Policy (CSP) Header Not Set" vulnerability,
 * need to set the Content-Security-Policy (CSP) header.
 * self -> Allow src from the same domain
 * data: -> Allow base64-encoded images
 * External sources (currently not used, but added coz that are commonly used):
 *  - Allow jQuery from the official CDN for JavaScript functionality
 *  - Allow styles from Google Fonts for typography
 *  - Allow font files from Google Fonts' gstatic domain
 * */
//header("Content-Security-Policy: default-src 'self'; script-src 'self' https://code.jquery.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; base-uri 'self'; frame-ancestors 'none'; form-action 'self'; report-uri /app-csp-violation; report-to default;");
//header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://code.jquery.com https://cdn.jsdelivr.net https://ajax.googleapis.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://use.fontawesome.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; base-uri 'self'; frame-ancestors 'none'; form-action 'self'; report-uri /app-csp-violation; report-to default;");
//header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://code.jquery.com https://cdn.jsdelivr.net https://ajax.googleapis.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://use.fontawesome.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://use.fontawesome.com https://cdnjs.cloudflare.com; img-src 'self' data:; object-src 'none'; base-uri 'self'; frame-ancestors 'none'; form-action 'self'; report-uri /app-csp-violation; report-to default;");
header("Content-Security-Policy: default-src * 'unsafe-inline' 'unsafe-eval'; script-src * 'unsafe-inline' 'unsafe-eval'; style-src * 'unsafe-inline'; font-src * data:; img-src * data:; object-src *; base-uri *; frame-ancestors *; form-action *; report-uri /app-csp-violation; report-to default;");

// Add Report-To header for structured CSP violation reporting
header("Report-To: { \"group\": \"default\", \"max_age\": 10886400, \"endpoints\": [{ \"url\": \"/app-csp-violation\" }] }");

/*
 * To fix the "Strict-Transport-Security Header Not Set" vulnerability,
 * need to ensure that all pages are served with HTTPS and HSTS headers are included,
 * we can add a script to set these headers in the application level.
 * ---* configuring this header at the server level is the recommended way for better security.
 * */
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    // Ensure that this script runs only for HTTPS requests
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
}

/*
 * Not fixed header related violations
 *  # Server Leaks Version Information via "Server" HTTP Response Header Field
 *  ---- Reason: Did not address this vulnerability because it requires changes at the server configuration level,
 *            which cannot be handled within the application code itself.
 *            Server-level adjustments are necessary to fix it properly.
 * */
