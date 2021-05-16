<?php
    error_reporting(E_ALL);

    date_default_timezone_set('Europe/Warsaw');

    $key = "key";
    $issued_at = time();
    $expiration_time = $issued_at + (60 *60);
    $issuer = "http://localhost/api"
?>