<?php
include 'inc/parsedown.php';
include('config.php');
if ($protect) {
    require_once('protect.php');
}
// error_reporting(E_ERROR);
date_default_timezone_set('UTC');
$EXPIRE = strtotime('+7 days'); // 7 days
?>
<html lang="en">
    <!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $title ?></title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="css/lit.css">
	<link rel="stylesheet" href="css/styles.css">
	<link href="https://fonts.googleapis.com/css2?family=Nunito" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
	<div class="c">
            <?php
            echo '<img class="gravatar" src="'.$gravatar.'" />';
            echo '<div id="center"><a href="index.php">'.$title.'</a></div>';
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
	    if(isset($_POST['newpage'])) {
		$pagename = $_POST["pagename"];
		$url = "index.php?page=".$pagename;
		if (!file_exists("content/".$pagename.".md")) {
	            fopen("content/".$pagename.".md", "w");
	            header( "Location: $url" );
		} else {
	            header( "Location: $url" );
		}
	    }
            if(isset($_POST['trash'])) {
		$MDFILE = $_COOKIE['mdfile'];
		rename($MDFILE, "trash/".basename($MDFILE));
		$url = 'index.php';
		header( "Location: $url" );
	    }
            $MDFILE = "content/".$page.".md";
            setcookie("page", $page, $EXPIRE);
            setcookie("mdfile", $MDFILE, $EXPIRE);
	    ?>
            <select class="card w-100" id="selectbox" name="" onchange="javascript:location.href = this.value;">
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
	    if(!is_file($MDFILE))
            {
		exit("<div id='center'>Page not found</div>");
            }
            echo "<div id='center'><form method='GET' action='edit.php'>
        <p style='margin-top:1em;'><button class='btn primary' type='submit'>Edit</button></p>
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
		echo " <button class='btn primary' style='margin-top: 0.5em;' type='submit' role='button' name='newpage'>New Page</button>";
		echo "</form>";
		echo "</div>";
            }
            if ($trash) {
		echo "<div id='center'  style='margin-top: 0.5em;'>";
		echo "<form method='post' action=''>";
		echo "<button class='btn' type='submit' role='button' name='trash'>Trash</button>";
		echo "</form>";
		echo "</div>";
            }
            ?>
	    <hr>
	    <?php echo $footer; ?>
	</div>
    </body>
</html>
