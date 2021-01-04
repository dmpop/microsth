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
	<?php
	echo '<h1><a href="index.php">' . $title . '</a></h1>';
	echo '<hr style="margin-bottom: 2em;">';
	if (isset($_GET["page"])) {
		$page = $_GET["page"];
	} else {
		echo "<p>Choose the desired page from the list below.</p>";
	}
	$md_file = "pub/" . $page . ".md";
	$_SESSION['page'] = $page;
	$_SESSION['mdfile'] = $md_file;
	?>
	<select name="" onchange="javascript:location.href = this.value;">
		<option value='Label'>Pages</option>";
		<?php
		$files = glob("pub/*.md");
		foreach ($files as $file) {
			$filename = basename($file);
			$name = basename($file, ".md");
			echo "<option value='?page=" . str_replace('\'', '&apos;', $name) . "'>" . $name . "</option>";
		}
		?>
	</select>
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
	<?php echo $footer; ?>
</body>

</html>