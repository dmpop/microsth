<?php
require_once('protect.php'); // Comment this line to remove password protection
include 'inc/parsedown.php';
include('config.php');
?>

<html lang="en">
    <!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->
    
    <head>
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/dark.min.css">
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
	     border-radius: 1em;
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
        echo '<img class="gravatar" src="'.$gravatar.'" />';
        echo '<div id="center"><a href="index.php">'.$title.'</a></div>';
	if (file_exists("random.md")) {
	    $f = file("random.md");
	    $line = $f[array_rand($f)];
	    $Parsedown = new Parsedown();
	    echo "<div id='center'><p style='margin-top:1.9em;'>".$Parsedown->text($line)."</p></div";
	}
	if (!file_exists("img")) {
	    mkdir("img", 0777, true);
	}
        echo "<div id='center'><form method='GET' action='edit.php'>
        <p style='margin-top:3em;'><button class='btn btn-primary' type='submit'>Edit</button></p>
            </form></div>";
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
		<button type='submit'>Edit</button>
            </p>
        </form>
            </div>
    </body>
</html>
