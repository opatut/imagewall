<?php
    /**
     * Ensures that a directory exists. Returns the input string.
     *
     * Usage: copy($from_file, ensure_file($to_file));
     */

    function ensure_file($in) {
        if(is_file($in)) return $in;
        ensure_directory(dirname($in));
        return $in;
    }


    /**
     * Ensures that a directory exists. Returns the input string.
     *
     * Usage: copy($from_file, ensure_file($to_dir));
     */

    function ensure_directory($dir) {
        if(is_dir($dir)) return $dir;
        mkdir($dir, 0777, true);
        return $dir;
    }
?>
