<?php
    if($wall->showRequiresPassword and !$wall->hasAccess()) {
        $mode = "upload";
        include("templates/wall-unlock.php");
    } else {
        $errors = [];

        if($form == "upload") {
            $title = trim($_POST["title"]);
            $description = trim($_POST["description"]);
            $author = trim($_POST["author"]);
            $file = $_FILES["file"];

            if($title == "") {
                $errors["title"] = "Bitte gib einen Titel für das Bild ein.";
            }
            if($file["name"] == "") {
                $errors["file"] = "Bitte wähle eine Bilddatei aus.";
            }

            if(!$errors) {
                $image = new Image();
                $result = $image->upload($wall, $title, $description, $author, $file);
                if($result == UPLOAD_ILLEGAL_EXTENSION) {
                    $errors["file"] = "Dieser Dateityp ist nicht erlaubt.";
                } elseif($result == UPLOAD_FAILED_TO_MOVE) {
                    $errors["file"] = "Die Datei konnte nicht hochgeladen werden :(";
                } elseif($result == UPLOAD_OK) {
                    header("Refresh: 3;url=?wall=" . $wall->slug);
                }
            }
        }

        if($form != "upload" or $errors) {
            global $errors;
            function errorPrint($key) {
                global $errors;
                if(isset($errors[$key]))
                    echo '<p class="error">' . $errors[$key] . '</p>';
            }

        ?>
        <form class="upload form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="form" value="upload" />

            <p><label for="file">Bilddatei: *</label><input type="file" name="file" id="file" class="file"></p>
            <?php errorPrint("file"); ?>

            <p><label for="title">Titel: *</label><input type="text" name="title" id="title" class="text"></p>
            <?php errorPrint("title"); ?>

            <p><label for="description">Beschreibung:</label><textarea name="description" id="description" rows="5"></textarea></p>
            <?php errorPrint("description"); ?>

            <p><label for="author">Autor:</label><input type="text" name="author" id="author" class="text"></p>
            <?php errorPrint("author"); ?>

            <p style="text-align: right"><input type="submit" class="btn" value="Hochladen" /></p>
        </form>
        <?php
        } else {
             echo '<ul class="images"><li style="margin-right: 20px;"><a href="?wall=' . $wall->slug . '&page=' . $image->id . '"><img src="' . $image->thumbnail . '"></a></li></ul>';

            echo '<p>Erfolgreich hochgeladen. Du wirst zur Imagewall weitergeleitet...</p>';
            echo '<p><a href="?wall=' . $wall->slug . '">Bring mich sofort dorthin!</a></p>';
        }
    }
?>
