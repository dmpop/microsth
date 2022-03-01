<!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<?php
include 'inc/parsedown.php';
include('config.php');
$pw_hash = password_hash($password, PASSWORD_DEFAULT);
if (isset($_GET['url']) && password_verify($_GET['password'], $pw_hash)) {
	$page = "content/pages/" . $_GET['page'] . ".md";
	if (!is_file($page)) {
		file_put_contents($page, '');
	}
	$note = $_GET['note'] . "\n\n";
	$note .= file_get_contents($page);
	file_put_contents($page, $note);
	header("location:" . $_GET['url'] . "");
	exit();
}
if ($protect) {
	require_once('protect.php');
}
?>
<html lang="en">
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
	<noscript>
		<p>Make sure that JavaScript is enabled.</p>
	</noscript>
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
	if (!file_exists("content")) {
		mkdir("content", 0755, true);
	}
	if (!file_exists("content/pages")) {
		mkdir("content/pages", 0755, true);
	}
	if (!file_exists("content/pub")) {
		mkdir("content/pub", 0755, true);
	}
	if (!file_exists("content/archive")) {
		mkdir("content/archive", 0755, true);
	}
	if (!file_exists("content/trash")) {
		mkdir("content/trash", 0755, true);
	}
	$trash_count = count(scandir("content/trash")) - 2;
	if ($trash_count >= $trash_limit) {
		$files = glob("content/trash/*");
		foreach ($files as $file) {
			unlink($file);
		}
	}
	if (!file_exists("content/img")) {
		mkdir("content/img", 0755, true);
	}
	if (isset($_GET["page"])) {
		$page = $_GET["page"];
		file_put_contents(".page", $page);
	} else {
		$page = $first_page;
		file_put_contents(".page", $page);
		if (!file_exists("content/pages/" . $page . ".md")) {
			fopen("content/pages/" . $page . ".md", "w");
			file_put_contents(".page", $page);
			$url = "index.php?page=" . $page;
			header("Location: $url");
		}
	}
	if (file_exists(".page")) {
		$page = file_get_contents('.page');
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
	if (isset($_POST["rename"])) {
		$md_file = file_get_contents('.mdfile');
		$pagename = $_POST["pagename"];
		rename($md_file, "content/pages/" . $pagename . ".md");
		$url = "index.php?page=" . $pagename;
		header("Location: $url");
	};
	if (isset($_POST['archive'])) {
		$md_file = file_get_contents('.mdfile');
		rename($md_file, "content/archive/" . basename($md_file));
		$url = 'index.php';
		header("Location: $url");
	}
	if (isset($_POST['trash'])) {
		$md_file = file_get_contents('.mdfile');
		rename($md_file, "content/trash/" . basename($md_file));
		if (file_exists("content/pub/" . basename($md_file))) {
			unlink("content/pub/" . basename($md_file));
		}
		$url = 'index.php';
		header("Location: $url");
	}
	if (isset($_POST['logout'])) {
		session_destroy();
		header('Location: login.php');
	}
	$md_file = "content/pages/" . $page . ".md";
	file_put_contents('.mdfile', $md_file);
	if (!is_file($md_file)) {
		exit("<p>Page not found</p>");
	}
	?>
	<div style='text-align: center;'>
		<form style='display:inline-block;' method='GET' action='edit.php'>
			<button style='margin-top: 1em;' type='submit'>Edit this page</button>
		</form>
		<form style='display:inline-block;' method='POST' action=''>
			<input style='margin-top: 1em;' type='submit' name='logout' value='Log out'></input>
		</form>
	</div>
	<?php
	if (($handle = fopen($md_file, "r")) !== FALSE) {
		$text = file_get_contents($md_file);
		$Parsedown = new Parsedown();
		echo $Parsedown->text($text);
		if (file_exists("content/pub/" . basename($md_file))) {
			echo '<div style="text-align: center; margin-top: 1.5em;"><a href="pub.php?page=' . basename($md_file, ".md") . '">Public link</a></div>';
		}
	}
	?>
	<hr style='margin-top: 2em; margin-bottom: 1.5em;'>
	<form method='POST' action=''>
		<label>Page name:
			<input style='display: inline;' type='text' name='pagename'>
		</label>
		<input style='display: inline;' type='submit' name='newpage' value='Create'>
		<input style='display: inline;' type='submit' name='rename' value='Rename'>
		<input style='display: inline;' type='submit' name='archive' value='Archive'></input>
		<input style='display: inline;' type='submit' name='trash' value='Trash'></input>
		<input style='display: inline;' type='submit' name='logout' value='Log out'></input>
	</form>
	<hr style="margin-bottom: 1.5em;">
	<div style="text-align: center;">
		<?php echo $footer; ?>
	</div>
</body>

</html>