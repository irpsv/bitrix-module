<div class="propertyViewChars arteastSimplecatalog__propertyView_chars">
    <?php
    $chars = $arResult['VALUE'];
    foreach ($chars as $char) {
        $value = $char['VALUE'];
        $desc = $char['DESCRIPTION'];

        echo "<div class='propertyViewCharsItem'>
            <div class='propertyViewCharsDesc'>
                <div class='propertyViewCharsDesc__value'>
                    {$desc}
                </div>
            </div>
            <div class='propertyViewCharsItem__value'>
                {$value}
            </div>
        </div>";
    }
    ?>
</div>
