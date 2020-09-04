<?php

namespace Verot\Upload;

include('inc/class.upload.php');
include('config.php');
if ($protect) {
	require_once('protect.php');
}
error_reporting(E_ERROR);
?>
<html lang='en'>

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
	<style>
		textarea {
			font-size: 15px;
			width: 100%;
			height: 55%;
			line-height: 1.9;
		}
	</style>
</head>

<body>
	<div class="uk-container uk-margin-small-top">
		<div class="uk-card uk-card-default uk-card-body">
			<?php
			echo '<h1 class="uk-heading-line uk-text-center"><a href="index.php">' . $title . '</a></h1>';
			echo '<a class="uk-button uk-button-default uk-margin-bottom" href="/' . $base_dir . '/?page=' . $_COOKIE["page"] . '">Back</a>';
			function Read()
			{
				$md_file = $_COOKIE['mdfile'];
				echo file_get_contents($md_file);
			}
			function Write()
			{
				$md_file = $_COOKIE['mdfile'];
				$fp = fopen($md_file, "w");
				$data = $_POST["text"];
				fwrite($fp, $data);
				fclose($fp);
			}
			if ($_POST["save"]) {
				Write();
			};
			?>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				<textarea class="uk-textarea" name="text"><?php Read(); ?></textarea>
				<input class="uk-button uk-button-primary uk-margin-top" type="submit" name="save" value="Save">
			</form>
			<?php
			if (isset($_POST['publish'])) {
				$md_file = $_COOKIE['mdfile'];
				if (!copy($md_file, "pub/" . basename($md_file))) {
					echo "Failed to copy basename($md_file) ";
				} else {
					echo "Published";
				}
			}
			?>
		</div>
		<div class="uk-card uk-card-primary uk-card-body">
			<form method="post" action="">
				<button class="uk-button uk-button-default" type="submit" role="button" name="publish">Publish</button>
				<?php
				$md_file = $_COOKIE['mdfile'];
				if (isset($_POST['unpublish'])) {
					unlink("pub/" . basename($md_file));
					echo "Unpublished";
				}
				if (file_exists("pub/" . basename($md_file))) {
					echo "<button class='uk-button uk-button-default' type='submit' role='button' name='unpublish'>Unpublish</button>";
				}
				echo "</form>";
				if (isset($_POST['upload'])) {
					$file_type = $_FILES['image_field']['type'];
					$allowed = array("image/jpeg");
					if (in_array($file_type, $allowed)) {
						$handle = new \verot\Upload\Upload($_FILES['image_field']);
						if ($handle->uploaded) {
							$handle->image_resize  = true;
							$handle->image_x = $resize;
							$handle->image_ratio_y = true;
							$handle->process('img');
							if ($handle->processed) {
								$filename = pathinfo(($_FILES['image_field']['name']), PATHINFO_FILENAME) . '.' . strtolower(pathinfo(($_FILES['image_field']['name']), PATHINFO_EXTENSION));
								echo '![](img/' . $filename . ')';
								$handle->clean();
							} else {
								echo 'error : ' . $handle->error;
							}
						}
					}
				}
				?>
				<form enctype="multipart/form-data" method="post" action="">
					<input class="uk-input" type="file" size="32" name="image_field" value="">
					<button class="uk-button uk-button-default" type="submit" role="button" name="upload">Upload</button>
				</form>
		</div>
		<hr>
		<?php echo $footer; ?>
	</div>
</body>

</html>