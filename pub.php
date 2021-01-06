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
	<h1 style="font-size: 2.5em; letter-spacing: 3px; color: rgb(200, 113, 55);"><?php echo $title ?></h1>
	<hr style="margin-bottom: 2em;">
	<?php
	if (isset($_GET["page"])) {
		$page = $_GET["page"];
	}
	$md_file = "pub/" . $page . ".md";
	$_SESSION['page'] = $page;
	$_SESSION['mdfile'] = $md_file;
	?>
	<select style="width: 100%;" name="" onchange="javascript:location.href = this.value;">
		<option value='Label'>Choose page</option>";
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