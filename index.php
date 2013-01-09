<?php
    /**
     * Miniature image wall by Paul Bienkowski.
     *
     * Change your configuration in config.inc.php. See
     * include/config.default.inc.php for available options.
     */

    include("init.php");

    $wall = null;
    if(isset($_GET["wall"])) {
        $wall = Wall::queryOne("WHERE slug = ?", $_GET["wall"]);
    }

    $form = "";
    if(isset($_GET["form"])) $form = $_GET["form"];
    elseif(isset($_POST["form"])) $form = $_POST["form"];

    if($form == "unlock") {
        $wall->getAccess($_POST["password"]);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/grid.css" />
    <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="js/imagewall.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <div id="header">
        <h1>Imagewall<?php if($wall) echo " - " . $wall->title; ?>
        <?php if($wall and $wall->hasAccess()) { ?>
            <i class="icon-unlock" title="Du hast vollen Zugriff auf diese Wall."></i>
        <?php } ?>
        </h1>

    </div>
    <div id="wrapper">
        <?php
            if($wall) {
                echo '<script>var currentWall = "' . $wall->slug. '";</script>';
                $page = isset($_GET["page"]) ? $_GET["page"] : "show";

                if($page == "show") {
                    include("templates/wall.php");
                } elseif($page == "stream") {
                    include("templates/wall-stream.php");
                } elseif($page == "upload") {
                    include("templates/wall-upload.php");
                } elseif(is_numeric($page)) {
                    $image = Image::get(intval($page));
                    include("templates/wall-image.php");
                }
            } else {
                include("templates/index.php");
            }
        ?>
    </div>
</body>
</html>
