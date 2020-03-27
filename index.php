<?php
include 'inc/parsedown.php';
include('config.php');
if ($protect) {
    require_once('protect.php');
}
ini_set('session.gc_maxlifetime', 10800); // Set session expiration to 180 min.
session_set_cookie_params(10800);
session_start();
?>
<html lang="en">
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
	        echo "<div id='center'><p style='margin-top:1.9em;'>".$Parsedown->text($line)."</p></div>";
	    }
	    if (!file_exists("img")) {
	        mkdir("img", 0777, true);
	    }
	    if (!file_exists("content")) {
	        mkdir("content", 0777, true);
	    }
	    if (!file_exists("trash")) {
	        mkdir("trash", 0777, true);
	    }
	    if(isset($_GET["page"])) {
	        $page = $_GET["page"];
	    } else {
            $page = $first_page;
            if (!file_exists("content/".$page.".md"))
            {
                fopen("content/".$page.".md", "w");
            }
	    }
        $MDFILE = "content/".$page.".md";
        $_SESSION['page'] = $page;
        $_SESSION['mdfile'] = $MDFILE;
	    ?>
        <select style="margin-top:1.9em;" id="selectbox" name="" onchange="javascript:location.href = this.value;">
            <option value='Label'>Pages</option>";
	    <?php
	    $files = glob("content/*.md");
	    foreach ($files as $file) {
		$filename = basename($file);
		$name = basename($file, ".md");
		echo "<option value='?page=".str_replace('\'', '&apos;', $name)."'>".$name."</option>";
	    }
	    ?>
	    </select>
	    <?php
	    if(isset($_POST['trash'])) {
	        $MDFILE = $_SESSION['mdfile'];
	        rename($MDFILE, "trash/".basename($MDFILE));
	        $url = 'index.php';
	        if (headers_sent()) {
	            die("Return <a href='$url'>Home</a>");
	        } else {
	            header( "Location: $url" );
	        }
	    }
	   if(isset($_POST['newpage'])) {
	       $pagename = $_POST["pagename"];
	       fopen("content/".$pagename.".md", "w");
	       $url = "index.php?page=".$pagename;
	       if (headers_sent()) {
	           die("Go to <a href='$url'>$pagename</a>");
	       } else {
	           header( "Location: $url" );
	       }
	   }
	   if(!is_file($MDFILE))
            {
                exit("<div id='center'>Page not found</div>");
            }
        echo "<div id='center'><form method='GET' action='edit.php'>
        <p style='margin-top:1em;'><button type='submit'>Edit</button></p>
        </form></div>";
        if (($handle = fopen($MDFILE, "r")) !== FALSE) {
            $text = file_get_contents($MDFILE);
            $Parsedown = new Parsedown();
            echo $Parsedown->text($text);
        }
        if ($newpage) {
            echo "<div id='center'>";
            echo "<form method='post' action=''>";
            echo " <label for='pagename'>Page name: </label>";
            echo "<input style='display: inline!important;' type='text' name='pagename'>";
            echo "<button style='margin-top: 0.5em;' type='submit' role='button' name='newpage'>New Page</button>";
            echo "</form>";
            echo "</div>";
        }
        if ($trash) {
            echo "<div id='center'  style='margin-top: 0.5em;'>";
            echo "<form method='post' action=''>";
            echo "<button type='submit' role='button' name='trash'>Trash</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
		<div id='center'><hr /><?php echo $footer; ?></div>
    </body>
</html>
