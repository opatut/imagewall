<form method="post" class="unlock form">
    <p>Um <?php
        if($mode == "upload")
            echo "ein Bild auf diese Wall hochzuladen";
        else
            echo "diese Wall anzuzeigen";
        ?>, musst du das Wall-Passwort eingeben:</p>

    <input type="hidden" name="form" value="unlock" />
    <?php
        if($form == "unlock") {
            echo '<p class="error">Falsches Passwort, versuch\'s nochmal!</p>';
        }
    ?>
    <p>
        <label>Passwort:</label><input type="password" name="password" class="password">
    </p>
    <p style="text-align: right;">
        <input type="submit" value="Freischalten" class="btn" />
    </p>
</form>
