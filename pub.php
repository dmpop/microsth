<?php
include 'inc/parsedown.php';
include('config.php');
error_reporting(E_ERROR);
?>
<html lang="en">

<!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<title><?php echo $title ?></title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="water.css" />
</head>

<body>
	<div style="text-align: center;">
		<img style="display: inline; height: 2.5em; border-radius: 0; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 style="display: inline; font-size: 1.9em; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; color: #ff6600;"><?php echo $title ?></h1>
		<hr style="margin-bottom: 2em; margin-top: 1em;">
	</div>
	<?php
	if (isset($_GET["page"])) {
		$page = $_GET["page"];
	}
	$md_file = "content/pub/" . $page . ".md";
	$_SESSION['page'] = $page;
	$_SESSION['mdfile'] = $md_file;
	?>
	<?php
	if (($handle = fopen($md_file, "r")) !== FALSE) {
		$text = file_get_contents($md_file);
		$Parsedown = new Parsedown();
		echo $Parsedown->text($text);
	} else {
		exit();
	}
	?>
	<hr style="margin-top: 2em; margin-bottom: 1.5em;">
	<div style="text-align: center;">
		<?php echo $footer; ?>
	</div>
</body>

</html>