<?php
include 'inc/parsedown.php';
include('config.php');
if ($protect) {
	require_once('protect.php');
}
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
	if (!file_exists("content")) {
		mkdir("content", 0777, true);
	}
	if (!file_exists("content/pages")) {
		mkdir("content/pages", 0777, true);
	}
	if (!file_exists("content/pub")) {
		mkdir("content/pub", 0777, true);
	}
	if (!file_exists("content/archive")) {
		mkdir("content/archive", 0777, true);
	}
	if (!file_exists("content/trash")) {
		mkdir("content/trash", 0777, true);
	}
	$trash_count = count(scandir("content/trash")) - 2;
	if ($trash_count >= $trash_limit) {
		$files = glob("content/trash/*");
		foreach ($files as $file) {
			unlink($file);
		}
	}
	if (!file_exists("content/img")) {
		mkdir("content/img", 0777, true);
	}
	if (isset($_GET["page"])) {
		$page = $_GET["page"];
	} else {
		$page = $first_page;
		if (!file_exists("content/pages/" . $page . ".md")) {
			fopen("content/pages/" . $page . ".md", "w");
		}
	}
	if (isset($_POST['newpage'])) {
		$pagename = $_POST["pagename"];
		$url = "index.php?page=" . $pagename;
		if (!file_exists("content/pages/" . $pagename . ".md")) {
			fopen("content/pages/" . $pagename . ".md", "w");
			header("Location: $url");
		} else {
			header("Location: $url");
		}
	}
	if (isset($_POST['archive'])) {
		$md_file = $_SESSION['mdfile'];
		rename($md_file, "content/archive/" . basename($md_file));
		$url = 'index.php';
		header("Location: $url");
	}
	if (isset($_POST['trash'])) {
		$md_file = $_SESSION['mdfile'];
		rename($md_file, "content/trash/" . basename($md_file));
		if (file_exists("content/pub/" . basename($md_file))) {
			unlink("content/pub/" . basename($md_file));
		}
		$url = 'index.php';
		header("Location: $url");
	}
	$md_file = "content/pages/" . $page . ".md";
	$_SESSION["page"] = $page;
	$_SESSION["mdfile"] = $md_file;
	?>
	<select style="width: 100%;" name="" onchange="javascript:location.href = this.value;">
		<option value='Label'>Go to page</option>";
		<?php
		$files = glob("content/pages/*.md");
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
        <button style='margin-top: 1.5em;'  type='submit'>Edit this page</button>
        </form>";
	if (($handle = fopen($md_file, "r")) !== FALSE) {
		$text = file_get_contents($md_file);
		$Parsedown = new Parsedown();
		echo $Parsedown->text($text);
		if (file_exists("content/pub/" . basename($md_file))) {
			echo '<p style="margin-top: 1.5em;"><a href="pub.php?page=' . basename($md_file, ".md") . '">Public link</a></p>';
		}
	}
	?>
	<hr style='margin-top: 2em; margin-bottom: 1.5em;'>
	<form method='POST' action=''>
		<label>Page name:
		<input style='display: inline;' type='text' name='pagename'>
		</label>
		<input style='display: inline;' type='submit' name='newpage' value='Create'>
		<input style='display: inline;' type='submit' name='archive' value='Archive'></input>
		<input style='display: inline;' type='submit' name='trash' value='Trash'></input>
	</form>
	<hr style="margin-bottom: 1.5em;">
	<?php echo $footer; ?>
</body>

</html>