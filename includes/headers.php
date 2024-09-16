<?php

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
header("Content-Security-Policy: 
    default-src 'self'; 
    script-src 'self' https://code.jquery.com; 
    style-src 'self' https://fonts.googleapis.com; 
    font-src 'self' https://fonts.gstatic.com; 
    img-src 'self' data:; 
    object-src 'none'; 
    base-uri 'self'; 
    frame-ancestors 'none'; 
    form-action 'self'; 
    report-uri /app-csp-violation;
    report-to default;
");

// Add Report-To header for structured CSP violation reporting
header("Report-To: { 
    \"group\": \"default\", 
    \"max_age\": 10886400, 
    \"endpoints\": [{ \"url\": \"/app-csp-violation\" }] 
}");
