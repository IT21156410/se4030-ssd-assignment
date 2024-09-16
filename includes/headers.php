<?php

/*
 * To fix the "X-Content-Type-Options Header Missing" vulnerability,
 * X-Content-Type-Options HTTP header need properly set to nosniff.
 * */
header('X-Content-Type-Options: nosniff');
