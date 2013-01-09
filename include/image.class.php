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

        public function getWall() {
            return Wall::get($this->wall_id);
        }

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
            $this->thumbnail = $config["file/uploads"] . "/" . $wall->slug . "/" . $this->id . "-152." . $extension;

            if(!move_uploaded_file($tmpName, ensure_file($this->file))) {
                $this->delete();
                echo "Failed to move uploaded file.";
                return UPLOAD_FAILED_TO_MOVE;
            }

            $this->save();

            // Convert to thumbnail size
            $img = new Imagick($this->file);
            $img->cropThumbnailImage(152,152);
            $img->setImagePage(0, 0, 0, 0);
            $img->writeImage(ensure_file($this->thumbnail));

            return UPLOAD_OK;
        }

    }

?>
