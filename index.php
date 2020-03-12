<?php
include 'inc/parsedown.php';
include('config.php');
if ($protect) {
    require_once('protect.php');
}
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
    .heart {
        fill: red;
		position: relative;
		top: 5px;
		width: 21px;
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
	if(isset($_GET["page"]))
        {
            $page = $_GET["page"];
        } else {
            $page = $first_page;
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
		echo "<option value='?page=$name'>".ucwords($name)."</option>";
	    }
	    ?>
	</select>
	<?php
        echo "<div id='center'><form method='GET' action='edit.php'>
        <p style='margin-top:1em;'><button type='submit'>Edit</button></p>
            </form></div>";
        if(!is_file($MDFILE))
        {
            $CONTENT = "Write something here";
            file_put_contents($MDFILE, $CONTENT);
        }
        if (($handle = fopen($MDFILE, "r")) !== FALSE) {
            $text = file_get_contents($MDFILE);
            $Parsedown = new Parsedown();
            echo $Parsedown->text($text);
        }
        ?>
        <hr />
		<div id='center'><?php echo $footer; ?>. I <svg class="heart" viewBox="0 0 32 29.6">
  <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2
	c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z"/>
	</svg> PHP</div>
    </body>
</html>
