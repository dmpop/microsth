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
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<meta name="viewport" content="width=device-width">
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="css/<?php echo $theme ?>.min.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	 body {
	     display: flex;
	     flex-direction: column;
	     max-width: 50rem;
	     margin: 0 auto;
	     padding: 0 0.9375rem;
	     line-height: 1.9;
	 }
	</style>
	<title>micro.sth</title>
    </head>
    <body>
        <div id='center'  style='margin-top: 3em;'>
            <form method="POST">
                <label for='pagename'>Password: </label>
	            <input style='display: inline!important;' type="password" name="password">
	            </form>
        </div>
    </body>
</html>
