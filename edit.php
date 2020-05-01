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
	<link rel="stylesheet" href="css/<?php echo $theme ?>.min.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
	<?php
	echo '<img class="gravatar" src="'.$gravatar.'" />';
	echo '<div id="center"><a href="index.php">'.$title.'</a></div>';
	echo '<div id="center" style="margin-bottom:1em; margin-top:1em;"><a href="/'.$base_dir.'/?page='.$_COOKIE["page"].'">Back</a></div>';
	function Read() {
            $MDFILE = $_COOKIE['mdfile'];
            echo file_get_contents($MDFILE);
	}
	function Write() {
            $MDFILE = $_COOKIE['mdfile'];
	    $fp = fopen($MDFILE, "w");
	    $data = $_POST["text"];
            fwrite($fp, $data);
            fclose($fp);
	}
	if ($_POST["submit_check"]) {
            Write();
	};
	?>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
	    <textarea name="text"><?php Read(); ?></textarea><br /><br />
	    <div id="center">
		<button style="display: inline;" type="submit" role="button" name="submit">Save</button>
		<input type="hidden" name="submit_check" value="1">
	</form>
	<?php
	if(isset($_POST['publish'])) {
            $MDFILE = $_COOKIE['mdfile'];
	    if (!copy($MDFILE, "pub/".basename($MDFILE))) {
		echo "Failed to copy basename($MDFILE) ";
            } else {
		echo "Published";
            }
	}
	?>
	<form style="display:inline!important;" method="post" action="">
            <button style="display: inline;" type="submit" role="button" name="publish">Publish</button>
	</form>
	<?php
	$MDFILE = $_COOKIE['mdfile'];
	if(isset($_POST['unpublish'])) {
            unlink("pub/".basename($MDFILE));
            echo "Unpublished";
	}
	if (file_exists("pub/".basename($MDFILE))) {
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
		<button style="display: inline;!important" type="submit" role="button" name="upload">Upload</button>
	    </form>
	</div>
	<hr />
	<div id='center'><?php echo $footer; ?></div>
    </body>
</html>
