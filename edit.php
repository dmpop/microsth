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
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $title ?></title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="css/lit.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
	<div class="c">
	    <?php
	    echo '<img class="gravatar" src="'.$gravatar.'" />';
	    echo '<div id="center"><a href="index.php">'.$title.'</a></div>';
	    echo '<div id="center" style="margin-bottom:1em; margin-top:1em;"><a href="/'.$base_dir.'/?page='.$_COOKIE["page"].'">Back</a></div>';
	    function Read() {
		$md_file = $_COOKIE['mdfile'];
		echo file_get_contents($md_file);
	    }
	    function Write() {
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
		<textarea class="card w-100" name="text"><?php Read(); ?></textarea><br /><br />
		<div id="center">
		    <input class="btn primary" style="display: inline;" type="submit" name="save" value="Save">
	    </form>
	    <?php
	    if(isset($_POST['publish'])) {
		$md_file = $_COOKIE['mdfile'];
		if (!copy($md_file, "pub/".basename($md_file))) {
		    echo "Failed to copy basename($md_file) ";
		} else {
		    echo "Published";
		}
	    }
	    ?>
	    <form style="display:inline!important;" method="post" action="">
		<button class="btn" style="display: inline;" type="submit" role="button" name="publish">Publish</button>
	    </form>
	    <?php
	    $md_file = $_COOKIE['mdfile'];
	    if(isset($_POST['unpublish'])) {
		unlink("pub/".basename($md_file));
		echo "Unpublished";
	    }
	    if (file_exists("pub/".basename($md_file))) {
		echo "<form style='display:inline!important;' method='post' action=''>";
		echo "<button style='display: inline;' type='submit' role='button' name='unpublish'>Unpublish</button>";
		echo "</form>";
	    }
	    if(isset($_POST['upload'])) {
		$file_type = $_FILES['image_field']['type'];
		$allowed = array("image/jpeg");
		if(in_array($file_type, $allowed)) {
		    $handle = new \verot\Upload\Upload($_FILES['image_field']);
		    if ($handle->uploaded) {
			$handle->image_resize  = true;
			$handle->image_x = $resize;
			$handle->image_ratio_y = true;
			$handle->process('img');
			if ($handle->processed) {
			    $filename = pathinfo(($_FILES['image_field']['name']), PATHINFO_FILENAME) . '.' . strtolower(pathinfo(($_FILES['image_field']['name']), PATHINFO_EXTENSION));
			    echo '![](img/'.$filename.')';
			    $handle->clean();
			} else {
			    echo 'error : ' . $handle->error;
			}
		    }
		}
	    }
	    ?>
	    <div id='center' style='margin-top: 1em;'>
		<form enctype="multipart/form-data" method="post" action="">
		    <input style='display: inline!important;' type="file" size="32" name="image_field" value="">
		    <button class="btn primary" style="display: inline;!important" type="submit" role="button" name="upload">Upload</button>
		</form>
	    </div>
	    <hr />
	    <div id='center'><?php echo $footer; ?></div>
    </body>
</html>
