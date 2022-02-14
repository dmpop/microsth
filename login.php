<?php
session_start();
$config = include('config.php');
$pw_hash = password_hash('secret', PASSWORD_DEFAULT);

/* Redirects here after login */
$redirect_after_login = 'index.php';

if (isset($_POST['password']) && password_verify($_POST['password'], $pw_hash)) {
	$_SESSION["password"] = $pw_hash;
	header('Location: ' . $redirect_after_login);
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="water.css" />
</head>

<body>
	<div style="text-align: center;">
		<img style="display: inline; height: 2.5em; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 class="text-center" style="display: inline; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; color: rgb(200, 113, 55);"><?php echo $title ?></h1>
		<hr style="margin-bottom: 2em; margin-top: 1em;">
	</div>
	<form method="POST">
		<p>Type password and press ENTER:</p>
		<input type="password" name="password">
	</form>
	<hr style="margin-top: 2em; margin-bottom: 1.5em;">
	<?php echo $footer; ?>
</body>

</html>