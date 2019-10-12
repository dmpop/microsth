<?php
require_once('protect.php');
?>

<html lang="en">
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
	     line-height: 1.9;
         }
         h1,
         h2,
         h3,
         h4 {
             font-size: 1.5em;
             margin-top: 2%;
         }
         img {
             max-width: 100%;
	     display: block;
	     align-self: center;
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
        echo '<div id="center"><a href="https://'.$_SERVER[HTTP_HOST].DIRECTORY_SEPARATOR.basename(__DIR__).'">micro.sth</a></div>';
        echo "<div id='center'><form method='GET' action='edit.php'>
        <p style='margin-top:3em;'><button class='btn btn-primary' type='submit'>Edit</button></p>
            </form></div>";
        include 'parsedown.php';
        $MDFILE = "data.md";
        if(!is_file($MDFILE))
        {
            $CONTENT = "Write something here";
            file_put_contents($MDFILE, $CONTENT);
        }
        if (($handle = fopen($MDFILE, "r")) !== FALSE) {
            $text = file_get_contents($MDFILE);
            $Parsedown = new Parsedown();
            $lines = file($MDFILE);
            $perpage = 100;
            $start = isset($_GET['start']) ? $_GET['start'] : 0;
            for($i = $start; $i <= ($start + $perpage); $i++){
		if($lines[$i] != ''){
		    echo $Parsedown->text($lines[$i]);
		}
            }
            echo '<div id="center">';
            for($j = 1; $j <= (count($lines) / $perpage)-1; $j++){
		if($start == $j){
		    echo $j;
		}
		else {
		    echo ' <a href="./?start=' . ($j * $perpage) . '">' . $j . '</a> ';
		}
            }
        }
        echo ' <a href="./?start=' . ($j * $perpage) . '">' . $j . '</a>';
        ?>
        <form method='GET' action='edit.php'>
            <p style=""margin-top:3em;">
		<button class="btn btn-primary" type='submit'>Edit</button>
            </p>
        </form>
            </div>
    </body>
</html>
