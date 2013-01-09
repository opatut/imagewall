<?php
    if($wall->showRequiresPassword and !$wall->hasAccess()) {
        $mode = "show";
        include("templates/wall-unlock.php");
    } else {
        echo "\n\n";
        echo '<script>var imageData = ' . encodeImageData($wall->getRecentImages(3)) . ';</script>';
        echo "\n\n";
        ?>

        <noscript class="error">
            <a href="?wall=<?php echo $wall->slug; ?>" class="btn">&laquo; Zurück zur Wall</a>

            Diese Seite benötigt JavaScript, um dir die Bilder nacheinander
            anzuzeigen (so einer Art Slideshow). Bitte aktiviere JavaScript
            in deinem Browser und lade die Seite erneut.
        </noscript>

        <div id="stream">
            <div id="slide" class="slide">
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

            <div id="top-3" class="top-3">
                <div id="top-3-row">
                    <div id="top-3-left">
                        <div id="top-3-1" class="top-3-image">
                            <img src="gfx/spinner.gif">
                            <div class="meta">
                                <div class="title"></div>
                                <div class="description">
                                    <span></span>
                                    <span class="author"></span>
                                    <span class="date"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="top-3-right">
                        <div id="top-3-2" class="top-3-image">
                            <img src="gfx/spinner.gif">
                            <div class="meta">
                                <div class="title"></div>
                                <div class="description">
                                    <span></span>
                                    <span class="author"></span>
                                    <span class="date"></span>
                                </div>
                            </div>
                        </div>
                        <div id="top-3-3" class="top-3-image">
                            <img src="gfx/spinner.gif">
                            <div class="meta">
                                <div class="title"></div>
                                <div class="description">
                                    <span></span>
                                    <span class="author"></span>
                                    <span class="date"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu">
                <a href="?wall=<?php echo $wall->slug; ?>" class="btn">&laquo; Zurück zur Wall</a>
                <select size="1" class="btn" id="mode-select">
                    <option value="top-3">Top 3</option>
                    <option value="slide">Slideshow</option>
                </select>
            </div>
        </div>

        <?php
    }
?>
