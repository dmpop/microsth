<?php
require_once('protect.php');
$config = include('config.php');
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
	<meta http-equiv="refresh" content="3;url=index.php" />
	<style>
	 body {
	     display: flex;
	     flex-direction: column;
	     max-width: 50rem;
	     margin: 0 auto;
	     padding: 0 0.9375rem;  
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
	echo '<img class="gravatar" src="'.$config['gravatar'].'" />';
        echo '<div id="center"><a href="index.php">'.$config['title'].'</a></div>';
	$DTSTAMP = date('Ymd-His');
	$MDFILE = 'data.md';
	$BACKUP = 'backup/'.$DTSTAMP.'.md';
	if (!file_exists('backup')) {
	    mkdir('backup', 0777, true);
	}
	if (!copy($MDFILE, $BACKUP)) {
	    echo "<div id='center'>Failed to copy $MDFILE!</div>";
	} else {
	    echo "<div id='center'>Backup completed!</div>";
	}
	?>
    </body>
</html>
