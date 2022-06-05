<?php
include 'inc/parsedown.php';
include('config.php');
?>
<html lang="en">

<!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<title><?php echo $title ?></title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/water.css" />
	<link rel="stylesheet" href="//unpkg.com/@highlightjs/cdn-assets@11.5.0/styles/default.min.css">
	<script src="//unpkg.com/@highlightjs/cdn-assets@11.5.0/highlight.min.js"></script>
	<script>
		hljs.highlightAll();
	</script>
</head>

<body>
	<div style="text-align: center;">
		<img style="display: inline; height: 2.5em; border-radius: 0; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 style="display: inline; font-size: 1.9em; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; color: #ff6600;"><?php echo $title ?></h1>
	</div>
	<hr style="margin-bottom: 2em; margin-top: 1em;">
	<noscript>
		<p>Make sure that JavaScript is enabled.</p>
	</noscript>
	<select style="width: 100%;" name="" onchange="javascript:location.href = this.value;">
		<option value='Label'>Go to page</option>";
		<?php
		$files = glob("content/pub/*.md");
		foreach ($files as $file) {
			$filename = basename($file);
			$name = basename($file, ".md");
			echo "<option value='?page=" . str_replace('\'', '&apos;', $name) . "'>" . $name . "</option>";
		}
		?>
	</select>
	<?php
	if (isset($_GET["page"])) {
		$page = "content/pub/" . $_GET["page"] . ".md";
	}
	if (($handle = fopen($page, "r")) !== FALSE) {
		$text = file_get_contents($page);
		$Parsedown = new Parsedown();
		echo $Parsedown->text($text);
	} else {
		exit("Nothing to see here.");
	}
	?>
	<div style="text-align: center;">
		<button style="margin-top: 1.3em;" onclick="window.location.href='<?php echo $base_dir . 'pub.php?page=' . $first_page ?>';">Home</button>
		<hr style="margin-top: 2em; margin-bottom: 1.5em;">
		<?php echo $footer; ?>
	</div>
</body>

</html>