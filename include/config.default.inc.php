<?php
    /**
     * This is the default configuration file. You may overwrite any of the
     * values set here in config.inc.php. You should rather not edit this file,
     * in case there will be changes in a new version.
     */

    $config = Array();

    $config["db/host"] = "localhost";
    $config["db/name"] = "imagewall";
    $config["db/user"] = "imagewall";
    $config["db/pass"] = "<set me in config.inc.php>";

    $config["session/lifetime"] = 14 * 24 * 60 * 60; // two weeks is reasonable

    $config["file/uploads"] = "images/";
?>
