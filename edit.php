<?php
namespace Verot\Upload;
require_once('protect.php');
include('inc/class.upload.php');
$config = include('config.php');
?>

<html lang='en'>
    <!-- Author: Dmitri Popov, dmpop@linux.com
         License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->
    <head>
	<meta charset="utf-8">
	<title>micro.sth</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="terminal.css">
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
	echo '<img class="gravatar" src="'.$config['gravatar'].'" />';
        echo '<div id="center"><a href="https://gitlab.com/dmpop/microsth">'.$config['title'].'</a></div>';
        ?>
        <div id='center'>
	    <form method="GET" action="index.php">
		<p style='margin-top:3em;'><button class="btn btn-primary" type="submit">Back</button></p>
            </form>
        </div>
        <?php
        function Read() {
	    $MDFILE = "data.md";
            echo file_get_contents($MDFILE);
        }
        function Write() {
	    $MDFILE = "data.md";
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
		<button style="display: inline;" class="btn btn-default" type="submit" role="button" name="submit">Save</button>
		<input type="hidden" name="submit_check" value="1">
        </form>
	<?php
	if(isset($_POST['submit'])){
	    $file_type = $_FILES['image_field']['type'];
	    $allowed = array("image/jpeg");
	    if(in_array($file_type, $allowed)) {
		$handle = new \verot\Upload\Upload($_FILES['image_field']);
		if ($handle->uploaded) {
		    $handle->image_resize  = true;
		    $handle->image_x = $config['resize'];
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
	    <button style="display: inline;" class="btn btn-default" type="submit" role="button" name="submit">Upload</button>
	</form>
	<form style="display:inline!important;" action="backup.php" method="get">
	    <button style="display: inline;" class="btn btn-primary" type="submit" role="button" name="submit">Backup</button>
	</form>
            </div>
    </body>
</html>
