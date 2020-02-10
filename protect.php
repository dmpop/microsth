<?php
include('config.php');

if (empty($_COOKIE['password']) || $_COOKIE['password'] !== $passwd) {
    // Password not set or incorrect. Send to login.php.
    header('Location: login.php');
    exit;
}
?>
