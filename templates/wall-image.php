<?php
    if($wall->showRequiresPassword and !$wall->hasAccess()) {
        $mode = "show";
        include("templates/wall-unlock.php");
    } else {
        ?>

        <p style="float: right; text-align: right;">
            <a href="?wall=<?php echo $wall->slug; ?>" class="btn">&laquo; Zurück zur Wall</a>
            <a href="<?php echo $image->file; ?>" class="btn">Bild herunterladen</a>
        </p>
        <table>
            <tr><th>Titel</th><td><?php echo $image->title; ?></td></tr>
            <tr><th>Hochgeladen am</th><td><?php echo $image->date; ?></td></tr>

            <?php if($image->author) { ?>
            <tr><th>Hochgeladen von</th><td><?php echo $image->author; ?></td></tr>
            <?php } ?>

            <?php if($image->description) { ?>
            <tr><th>Beschreibung</th><td>
                <p><?php echo $image->description; ?></p>
            </td></tr>
            <?php } ?>
        </table>
        <br />
        <?php

        echo '<div class="fullsize">';
        echo '<img src="' . $image->file . '" />';
        echo '</div>';
    }
?>
