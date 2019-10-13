<?php
require_once('protect.php');
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
	$gravatar_link = 'https://icotar.com/avatar/monkey.png';
	echo '<img class="gravatar" src="'.$gravatar_link.'" />';
        echo '<div id="center"><a href="index.php">micro.sth</a></div>';
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
		<button class="btn btn-default btn-ghost" type="submit" role="button" name="submit">Save</button>
		<input type="hidden" name="submit_check" value="1">
        </form>

        <form action="backup.php" method="get">
	    <p style="margin-top:3em;" >
		<button class="btn btn-primary" type="submit" role="button" name="submit">Backup</button>
	</form>
            </div>
    </body>
</html>
