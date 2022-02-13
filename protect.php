<?php
session_start();
include('config.php');
$pw_hash = password_hash('secret', PASSWORD_DEFAULT);

if (empty($_SESSION['password']) || password_verify($_SESSION['password'], $pw_hash)) {
    // Password not set or incorrect. Send to login.php.
    header('Location: login.php');
    exit;
}
