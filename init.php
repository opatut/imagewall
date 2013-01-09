<?php

    include("include/config.default.inc.php");
    if(file_exists("config.inc.php")) {
        include("config.inc.php");
    }

    /*
        URL scheme:

        / - Homepage
        /<wall>/ - Wall overview
        /<wall>/live/ - Wall "livestream"
        /<wall>/upload/ - Upload to a wall
        /<wall>/<imgid>/ - Image details
    */

    session_set_cookie_params($config["session/lifetime"]);
    session_start();

    global $db, $config;
    $db = new PDO("mysql:dbname=" . $config["db/name"] . ";host=" . $config["db/host"], $config["db/user"], $config["db/pass"]);

    include("include/functions.inc.php");
    include("include/model.class.php");
    include("include/wall.class.php");
    include("include/image.class.php");

?>
