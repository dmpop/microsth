<?php
include 'inc/parsedown.php';
include('config.php');
if ($protect) {
	require_once('protect.php');
}
// error_reporting(E_ERROR);
date_default_timezone_set('UTC');
$EXPIRE = strtotime('+7 days'); // 7 days
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
	<h1 style="font-size: 2.5em; letter-spacing: 3px; color: rgb(200, 113, 55);"><?php echo $title ?></h1>
	<hr style="margin-bottom: 2em;">
	<noscript>
		<p>Make sure that JavaScript is enabled.</p>
	</noscript>
	<?php
	if (!file_exists("img")) {
		mkdir("img", 0777, true);
	}
	if (!file_exists("content")) {
		mkdir("content", 0777, true);
	}
	if (!file_exists("pub")) {
		mkdir("pub", 0777, true);
	}
	if (!file_exists("trash")) {
		mkdir("trash", 0777, true);
	}
	if (isset($_GET["page"])) {
		$page = $_GET["page"];
	} else {
		$page = $first_page;
		if (!file_exists("content/" . $page . ".md")) {
			fopen("content/" . $page . ".md", "w");
		}
	}
	if (isset($_POST['newpage'])) {
		$pagename = $_POST["pagename"];
		$url = "index.php?page=" . $pagename;
		if (!file_exists("content/" . $pagename . ".md")) {
			fopen("content/" . $pagename . ".md", "w");
			header("Location: $url");
		} else {
			header("Location: $url");
		}
	}
	if (isset($_POST['trash'])) {
		$md_file = $_COOKIE['mdfile'];
		rename($md_file, "trash/" . basename($md_file));
		if (file_exists("pub/" . basename($md_file))) {
			unlink("pub/" . basename($md_file));
		}
		$url = 'index.php';
		header("Location: $url");
	}
	$md_file = "content/" . $page . ".md";
	setcookie("page", $page, $EXPIRE);
	setcookie("mdfile", $md_file, $EXPIRE);
	?>
	<select name="" onchange="javascript:location.href = this.value;">
		<option value='Label'>Pages</option>";
		<?php
		$files = glob("content/*.md");
		foreach ($files as $file) {
			$filename = basename($file);
			$name = basename($file, ".md");
			echo "<option value='?page=" . str_replace('\'', '&apos;', $name) . "'>" . $name . "</option>";
		}
		?>
	</select>
	<?php
	if (!is_file($md_file)) {
		exit("<p>Page not found</p>");
	}
	echo "<form method='GET' action='edit.php'>
        <p style='margin-top:1em;'><button type='submit'>Edit</button></p>
        </form>";
	if (($handle = fopen($md_file, "r")) !== FALSE) {
		$text = file_get_contents($md_file);
		$Parsedown = new Parsedown();
		echo $Parsedown->text($text);
	}
	?>
	<hr style='margin-top: 2em; margin-bottom: 1.5em;'>
	<form method='POST' action=''>
		<label for='pagename'>Page name: </label>
		<input style='display: inline;' type='text' name='pagename'>
		<input style='display: inline;' type='submit' name='newpage' value='Create'>
		<input style='display: inline; background-color: #ffcccc;' type='submit' name='trash' value='Trash'></input>
	</form>
	<hr style="margin-bottom: 1.5em;">
	<?php echo $footer; ?>
</body>

</html>