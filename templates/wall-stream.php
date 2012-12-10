<?php
    if($wall->showRequiresPassword and !$wall->hasAccess()) {
        $mode = "show";
        include("templates/wall-unlock.php");
    } else {
        $data = Array();
        foreach($wall->getRecentImages(3) as $i) {
            $data[] = Array(
                "file" => $i->file,
                "title" => $i->title,
                "description" => $i->description,
                "url" => "?wall=" . $wall->slug . "&page=" . $i->id,
                "author" => $i->author,
                "date" => $i->date
            );
        }

        echo "\n\n";
        echo '<script>var imageData = ' . json_encode($data) . ';</script>';
        echo "\n\n";
        ?>

        <noscript class="error">
            <a href="?wall=<?php echo $wall->slug; ?>" class="btn">&laquo; Zurück zur Wall</a>

            Diese Seite benötigt JavaScript, um dir die Bilder nacheinander
            anzuzeigen (so einer Art Slideshow). Bitte aktiviere JavaScript
            in deinem Browser und lade die Seite erneut.
        </noscript>

        <div id="stream">
            <div id="slide" style="display: none;" class="slide">
                <div class="image-row"><div class="image">
                    <img src="" style="display: none;" />
                </div></div>
                <div class="meta">
                    <div class="title"></div>
                    <div class="description">
                        <span></span>
                        <span class="author"></span>
                        <span class="date"></span>
                    </div>
                </div>
            </div>

            <div class="menu">
                <a href="?wall=<?php echo $wall->slug; ?>" class="btn">&laquo; Zurück zur Wall</a>
            </div>
        </div>

        <?php
    }
?>
