<?php
include('config.php');

if (empty($_COOKIE['password']) || password_verify($_COOKIE['password'], $password)) {
    // Password not set or incorrect. Send to login.php.
    header('Location: login.php');
    exit;
}
