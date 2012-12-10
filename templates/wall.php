<?php
    if($wall->showRequiresPassword and !$wall->hasAccess()) {
        $mode = "show";
        include("templates/wall-unlock.php");
    } else {
        echo '<a href="?wall=' . $wall->slug . '&page=upload" class="btn">Bild hochladen</a> ';
        echo '<a href="?wall=' . $wall->slug . '&page=stream" class="btn">Beamer-Modus</a> ';

        echo '<p>' . $wall->description . '</p>';

        echo '<ul class="images">';
        foreach($wall->getImages() as $i) {
            echo '<li><a title="' . $i->title . '" href="?wall=' . $wall->slug . '&page=' . $i->id . '"><img src="' . $i->file . '" /></li>';
        }
        echo '</ul>';
    }
?>
