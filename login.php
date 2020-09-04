<?php
$config = include('config.php');

/* Redirects here after login */
$redirect_after_login = 'edit.php';

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
	<title><?php echo $title; ?></title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/css/uikit.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit-icons.min.js"></script>
</head>

<body>
	<div class="uk-container uk-margin-small-top">
		<div class="uk-card uk-card-primary uk-card-body">
			<h1 class="uk-heading-line uk-text-center"><span><?php echo $title; ?></span></h1>
			<form class="uk-text-center" method="POST">
				<p>Type password and press ENTER:</p>
				<input class=uk-input" type="password" name="password">
			</form>
		</div>
	</div>
</body>

</html>