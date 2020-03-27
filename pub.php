<?php
include 'inc/parsedown.php';
include('config.php');
error_reporting(E_ERROR);
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
    echo '<div id="center"><a href="https://gitlab.com/dmpop/microsth">'.$title.'</a></div>';
    if (file_exists("random.md")) {
        $f = file("random.md");
        $line = $f[array_rand($f)];
        $Parsedown = new Parsedown();
        echo "<div id='center'><p style='margin-top:1.9em;'>".$Parsedown->text($line)."</p></div>";
    }
	if(isset($_GET["page"]))
        {
            $page = $_GET["page"];
    } else {
            echo "Choose the desired page from the list below.";
    }
    $MDFILE = "pub/".$page.".md";
    $_SESSION['page'] = $page;
    $_SESSION['mdfile'] = $MDFILE;
	?>
    <select style="margin-top:1.9em;" id="selectbox" name="" onchange="javascript:location.href = this.value;">
        <option value='Label'>Pages</option>";
    <?php
    $files = glob("pub/*.md");
    foreach ($files as $file) {
        $filename = basename($file);
		$name = basename($file, ".md");
		echo "<option value='?page=".str_replace('\'', '&apos;', $name)."'>".$name."</option>";
    }
    ?>
    </select>
	<?php
    if (($handle = fopen($MDFILE, "r")) !== FALSE) {
        $text = file_get_contents($MDFILE);
        $Parsedown = new Parsedown();
        echo $Parsedown->text($text);
    } else {
            exit();
    }
    ?>
    </div>
    <div id='center'  style='margin-top: 1em;'><hr /><?php echo $footer; ?></div>
    </body>
</html>
