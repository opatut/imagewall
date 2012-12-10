<p>Verfügbare Image Walls:</p>

<ul>
    <?php
        foreach(Wall::all() as $w) {
            echo '<li>';
            echo '<a href="?wall=' . $w->slug . '">' . $w->title . '</a>';
            if($w->showRequiresPassword) {
                if($w->hasAccess()) {
                    echo ' <i class="icon-unlock"></i title="Du hast vollen Zugriff auf diese Wall.">';
                } else {
                    echo ' <i class="icon-lock" title="Um diese Wall anzuzeigen brauchst du das Passwort."></i>';
                }
            }
            echo '</li>';
        }
    ?>
</ul>
