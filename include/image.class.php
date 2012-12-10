<?php
    global $allowedExtensions;
    $allowedExtensions = array("jpg", "jpeg", "gif", "png", "bmp", "svg", "tif", "tiff");

    define("UPLOAD_OK", 0);
    define("UPLOAD_ILLEGAL_EXTENSION", 1);
    define("UPLOAD_FAILED_TO_MOVE", 2);
    define("UPLOAD_FAILED_TO_CONVERT", 3);

    class Image extends Model {
        public static $table = "image";

        public
            $id = 0,
            $wall_id = 0,
            $title = "",
            $description = "",
            $author = "",
            $file = "",
            $thumbnail = "",
            $date = null;

        public function upload($wall, $title, $description, $author, $fileInfo) {
            $tmpName = $fileInfo["tmp_name"];
            $originalName = basename($fileInfo["name"]);
            $extension = end(explode(".", strtolower($originalName)));

            global $allowedExtensions;
            if(!in_array($extension, $allowedExtensions)) {
                echo "Illegal extension.";
                return UPLOAD_ILLEGAL_EXTENSION;
            }

            $this->title = $title;
            $this->description = $description;
            $this->author = $author;
            $this->date = date("Y-m-d H:i:s");
            $this->wall_id = $wall->id;
            $this->save(); // gets an ID

            // move the temporary file to its destiny
            global $config;
            $this->file = $config["file/uploads"] . "/" . $wall->slug . "/" . $this->id . "." . $extension;

            if(!move_uploaded_file($tmpName, ensure_file($this->file))) {
                $this->delete();
                echo "Failed to move uploaded file.";
                return UPLOAD_FAILED_TO_MOVE;
            }

            $this->save();

            // TODO: Convert to thumbnail size
            $this->thumbnail = $this->file;

            return UPLOAD_OK;
        }

    }

?>
