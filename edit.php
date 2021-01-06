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
	<link rel="stylesheet" href="water.css" />
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
	<h1 style="font-size: 2.5em; letter-spacing: 3px; color: rgb(200, 113, 55);"><?php echo $title ?></h1>
	<hr style="margin-bottom: 2em;">
	<button style="margin-bottom: 1.3em;" onclick="window.location.href='<?php echo $base_dir . '?page=' . $_COOKIE['page'] ?>';">Back</button>
	<?php
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
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<textarea name="text"><?php Read(); ?></textarea>
		<input style="float: left; margin-top: 1em;" type="submit" name="save" value="Save">
	</form>
	<?php
	if (isset($_POST['publish'])) {
		$md_file = $_COOKIE['mdfile'];
		if (!copy($md_file, "pub/" . basename($md_file))) {
			echo "<script>";
			echo 'alert("Failed to publish "' . basename($md_file) . '")';
			echo "</script>";
		} else {
			echo "<script>";
			echo 'alert("Page has been published.")';
			echo "</script>";
		}
	}
	?>
	<form method="POST" action="">
		<?php
		$md_file = $_COOKIE['mdfile'];
		if (isset($_POST['unpublish'])) {
			unlink("pub/" . basename($md_file));
			echo "<script>";
			echo 'alert("Page has been unpublished.")';
			echo "</script>";
		}
		if (isset($_POST['update'])) {
			unlink("pub/" . basename($md_file));
			copy($md_file, "pub/" . basename($md_file));
			echo "<script>";
			echo 'alert("Page has been updated.")';
			echo "</script>";
		}
		if (!file_exists("pub/" . basename($md_file))) {
			echo '<input type="submit" name="publish" value="Publish" />';
		}
		if (file_exists("pub/" . basename($md_file))) {
			echo "<input style='float: left;' type='submit' name='update' value='Update' />";
			echo "<input type='submit' name='unpublish' value='Unpublish' />";
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
						echo "<script>";
						echo 'alert("Insert image: ![](img/' . $filename . ')")';
						echo "</script>";
						$handle->clean();
					} else {
						echo "<script>";
						echo 'alert("Error: ' . $handle->error . ')"';
						echo "</script>";
					}
				}
			}
		}
		?>
		<form style="margin-top: 2em;" enctype="multipart/form-data" method="POST" action="">
			<input style="display: inline;" type="file" size="32" name="image_field" value="">
			<button style="display: inline;" type="submit" role="button" name="upload">Upload</button>
		</form>
		<hr>
		<?php echo $footer; ?>
</body>

</html>