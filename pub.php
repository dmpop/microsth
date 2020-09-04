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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/css/uikit.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit-icons.min.js"></script>
</head>

<body>
	<div class="uk-container uk-margin-small-top">
		<div class="uk-card uk-card-default uk-card-body">
			<?php
			echo '<h1 class="uk-heading-line uk-text-center"><a href="index.php">' . $title . '</a></h1>';
			if (isset($_GET["page"])) {
				$page = $_GET["page"];
			} else {
				echo "Choose the desired page from the list below.";
			}
			$md_file = "pub/" . $page . ".md";
			$_SESSION['page'] = $page;
			$_SESSION['mdfile'] = $md_file;
			?>
			<select class="uk-select" name="" onchange="javascript:location.href = this.value;">
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
		</div>
		<hr>
		<?php echo $footer; ?>
	</div>
</body>

</html>