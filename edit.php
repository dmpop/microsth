<?php
namespace Verot\Upload;
include('inc/class.upload.php');
include('config.php');
if ($protect) {
    require_once('protect.php');
}
error_reporting(E_ERROR);
session_start();
?>
<html lang='en'>
    <!-- Author: Dmitri Popov, dmpop@linux.com
         License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $title ?></title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="css/<?php echo $theme ?>.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	 body {
	     display: flex;
	     flex-direction: column;
	     max-width: 50rem;
	     margin: 0 auto;
	     padding: 0 0.9375rem;  
         }
	 textarea {
	     font-size: 15px;
	     width: 100%;
	     height: 25em;
	     line-height: 1.9;
	 }
	 img {
	     display: block;
	     margin-left: auto;
	     margin-right: auto;
	     margin-top: 1%;
	     margin-bottom: 1%;
	     width: 600px;
         }
	 img.gravatar {
             border-radius: 50%;
             display: block;
	     margin-left: auto;
	     margin-right: auto;
	     margin-top: 5%;
	     margin-bottom: 1%;
	     height: 96px;
	     width: 96px;
         }
	 #center {
             text-align: center;
             margin: 0 auto;
         }
	</style>
    </head>
    <body>
	<?php
	    echo '<img class="gravatar" src="'.$gravatar.'" />';
        echo '<div id="center"><a href="https://gitlab.com/dmpop/microsth">'.$title.'</a></div>';
        echo '<div id="center" style="margin-bottom:1em; margin-top:1em;"><a href="/'.$base_dir.'/?page='.$_SESSION["page"].'">Back</a></div>';
        function Read() {
	    $MDFILE = $_SESSION['mdfile'];
            echo file_get_contents($MDFILE);
        }
        function Write() {
	    $MDFILE = $_SESSION['mdfile'];
            $fp = fopen($MDFILE, "w");
            $data = $_POST["text"];
            fwrite($fp, $data);
            fclose($fp);
        }
        ?>
        <?php
        if ($_POST["submit_check"]){
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
	if(isset($_POST['publish'])){
	    $MDFILE = $_SESSION['mdfile'];
	    if (!copy($MDFILE, "pub/".basename($MDFILE))) {
            echo "Failed to copy basename($MDFILE) ";
        }
	}
        
        ?>
        <form style="display:inline!important;" method="post" action="">
	        <button style="display: inline;" type="submit" role="button" name="publish">Publish</button>
	    </form>
	<?php
	if(isset($_POST['upload'])){
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
			echo '![](img/'.($_FILES['image_field']['name']).')';
			$handle->clean();
		    } else {
			echo 'error : ' . $handle->error;
		    }
		}
	    }
	}
	?>
	<form style="display:inline!important;" enctype="multipart/form-data" method="post" action="">
	    <input type="file" size="32" name="image_field" value="">
	        <button style="display: inline;" type="submit" role="button" name="upload">Upload</button>
	</form>
        </div>
    </body>
</html>
