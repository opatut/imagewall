<?php
    class Wall extends Model {
        public static $table = "wall";

        public
            $id = 0,
            $title = "",
            $slug = "",
            $description = "",
            $password = "",
            $showRequiresPassword = false,
            $uploadRequiresPassword = true;


        public function hasAccess() {
            return isset($_SESSION["wall-" . $this->id]) and md5($_SESSION["wall-" . $this->id]) == $this->password;
        }

        public function getAccess($password) {
            // save the md5 of the cleartext in the session
            $_SESSION["wall-" . $this->id] = md5($password);
            return $this->hasAccess();
        }

        public function getImages() {
            return Image::query("WHERE wall_id = ? ORDER BY date DESC", $this->id);
        }

        public function getRecentImages($count = 10) {
            return Image::query("WHERE wall_id = ? ORDER BY date DESC LIMIT " . intval($count), $this->id);
        }
    }

    function encodeImageData($images) {
        $data = Array();
        foreach($images as $i) {
            $data[] = Array(
                "file" => $i->file,
                "title" => $i->title,
                "description" => $i->description,
                "url" => "?wall=" . $i->getWall()->slug . "&page=" . $i->id,
                "author" => $i->author,
                "date" => $i->date
            );
        }
        return json_encode($data);
    }
?>
