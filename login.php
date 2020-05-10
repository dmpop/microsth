<?php
$config = include('config.php');

/* Redirects here after login */
$redirect_after_login = 'index.php';

/* Set timezone to UTC */

date_default_timezone_set('UTC');

/* Will not ask password again for */
$remember_password = strtotime('+30 days'); // 30 days

if (isset($_POST['password']) && $_POST['password'] == $passwd) {
    setcookie("password", $passwd, $remember_password);
    header('Location: ' . $redirect_after_login);
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width">
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="css/lit.css">
	<link rel="stylesheet" href="css/styles.css">
	<link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title ?></title>
    </head>
    <body>
        <div class="c">
	    <h1><?php echo $title ?></h1>
	    <hr>
	    <p>
		Enter password and press ENTER to log in.
	    </p>
	    <form method="POST">
                <label for='pagename'>Password: </label>
	        <input type="password" name="password">
	    </form>
        </div>
    </body>
</html>
