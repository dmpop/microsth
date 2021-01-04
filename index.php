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
	<?php
	echo '<h1><a href="index.php">' . $title . '</a></h1>';
	echo '<hr style="margin-bottom: 2em;">';
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
		$MDFILE = $_COOKIE['mdfile'];
		rename($MDFILE, "trash/" . basename($MDFILE));
		$url = 'index.php';
		header("Location: $url");
	}
	$MDFILE = "content/" . $page . ".md";
	setcookie("page", $page, $EXPIRE);
	setcookie("mdfile", $MDFILE, $EXPIRE);
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
	if (!is_file($MDFILE)) {
		exit("<div id='center'>Page not found</div>");
	}
	echo "<form method='GET' action='edit.php'>
        <p style='margin-top:1em;'><button type='submit'>Edit</button></p>
        </form>";
	if (($handle = fopen($MDFILE, "r")) !== FALSE) {
		$text = file_get_contents($MDFILE);
		$Parsedown = new Parsedown();
		echo $Parsedown->text($text);
	}
	if ($newpage) {
		echo "<hr style='margin-top: 2em; margin-bottom: 1.5em;'>";
		echo "<form method='post' action=''>";
		echo " <label for='pagename'>Page name: </label>";
		echo "<input style='display: inline;' type='text' name='pagename'>";
		echo "<input style='display: inline;' type='submit' name='newpage' value='Create'>";
	}
	if ($trash) {
		echo " <input style='display: inline;' type='submit' name='trash' value='Trash'></input>";
		echo "</form>";
	}
	?>
	<hr style="margin-bottom: 1.5em;">
	<?php echo $footer; ?>
</body>

</html>