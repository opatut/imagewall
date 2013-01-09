<?php
    /**
     * AJAX Request handler script.
     */

    include("init.php");

    $node = isset($_GET["node"]) ? $_GET["node"] : "undefined";
    $wall = isset($_GET["wall"]) ? $_GET["wall"] : 0;
    $wall = Wall::queryOne("WHERE slug = ?", $wall);

    if($node == "recent-images") {
        $count = isset($_GET["count"]) ? $_GET["count"] : 3;
        echo encodeImageData($wall->getRecentImages(3));
        exit;
    } else if($node == "undefined" or $node == "") {
        echo "Die potato!";
        exit;
    }

?>
