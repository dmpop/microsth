<?php
// Upload class: https://github.com/verot/class.upload.php
namespace Verot\Upload;

include('inc/class.upload.php');
include('config.php');
if ($protect) {
	require_once('protect.php');
} else {
	session_start();
}
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
	<div style="text-align: center;">
		<img style="display: inline; height: 2.5em; border-radius: 0; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 style="display: inline; font-size: 1.9em; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; color: #ff6600;"><?php echo $title ?></h1>
		<hr style="margin-bottom: 2em; margin-top: 1em;">
		<button style="margin-bottom: 1.3em;" onclick="window.location.href='<?php echo $base_dir . '?page=' . file_get_contents('.page') ?>';">Back</button>
	</div>
	<?php
	function Read()
	{
		$page_path = file_get_contents('.path');
		echo file_get_contents($page_path);
	}
	if (isset($_POST["save"])) {
		$page_path = file_get_contents('.path');
		$data = $_POST["text"];
		file_put_contents($page_path, $data);
		echo "<script>";
		echo 'alert("Changes have been saved.")';
		echo "</script>";
	};
	?>
	<div style="text-align: center;">
		<form style="display: inline;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<textarea name="text"><?php Read(); ?></textarea>
			<input style="display: inline; margin-top: 1em; color:#009933;" type="submit" name="save" value="Save">
		</form>
		<?php
		if (isset($_POST['publish'])) {
			$page_path = file_get_contents('.path');
			if (!copy($page_path, "content/pub/" . basename($page_path))) {
				echo "<script>";
				echo 'alert("Failed to publish "' . basename($page_path) . '")';
				echo "</script>";
			} else {
				echo "<script>";
				echo 'alert("Page has been published.")';
				echo "</script>";
			}
		}
		?>
		<form style="display: inline;" method="POST" action="">
			<?php
			$page_path = file_get_contents('.path');
			if (isset($_POST['unpublish'])) {
				unlink("content/pub/" . basename($page_path));
				echo "<script>";
				echo 'alert("Page has been unpublished.")';
				echo "</script>";
			}
			if (isset($_POST['update'])) {
				unlink("content/pub/" . basename($page_path));
				copy($page_path, "content/pub/" . basename($page_path));
				echo "<script>";
				echo 'alert("Page has been updated.")';
				echo "</script>";
			}
			if (!file_exists("content/pub/" . basename($page_path))) {
				echo '<input style="display: inline;" type="submit" name="publish" value="Publish" />';
			}
			if (file_exists("content/pub/" . basename($page_path))) {
				echo '<input style="display: inline; color:#00aaff;" type="submit" name="update" value="Update" />';
				echo '<input style="display: inline;" type="submit" name="unpublish" value="Unpublish" />';
			}
			?>
		</form>
	</div>
	<?php
	if (isset($_POST['upload'])) {
		$file_type = $_FILES['image_field']['type'];
		$allowed = array("image/jpeg");
		if (in_array($file_type, $allowed)) {
			$handle = new \verot\Upload\Upload($_FILES['image_field']);
			if ($handle->uploaded) {
				$handle->image_resize  = true;
				$handle->image_x = $resize;
				$handle->image_ratio_y = true;
				$handle->process('content/img');
				if ($handle->processed) {
					$filename = pathinfo(($_FILES['image_field']['name']), PATHINFO_FILENAME) . '.' . strtolower(pathinfo(($_FILES['image_field']['name']), PATHINFO_EXTENSION));
					echo "<script>";
					echo 'alert("Insert image: ![](content/img/' . $filename . ')")';
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
		<input style="display: inline; vertical-align: middle;" type="file" size="32" name="image_field" value="">
		<button style="vertical-align: middle; color:#00aaff;" type="submit" role="button" name="upload">Upload</button>
	</form>
	<hr>
	<div style="text-align: center;">
		<?php echo $footer; ?>
	</div>
</body>

</html>