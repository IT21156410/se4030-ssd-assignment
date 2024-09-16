<?php

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
