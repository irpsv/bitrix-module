<?php

$pictureIds = $arResult['VALUE'] ?: [];
$pictureIds = array_column($pictureIds, 'VALUE');

$mainPictureId = $arParams['MAIN_PICTURE'] ?? null;
array_unshift($pictureIds, $mainPictureId);

$pictureIds = array_filter($pictureIds);

$pictures = [];
$result = \CFile::getList([], [
    '@ID' => $pictureIds,
]);
while ($row = $result->fetch()) {
    $path = \COption::GetOptionString("main", "upload_dir", "upload") . "/{$row["SUBDIR"]}/{$row["FILE_NAME"]}";
    $pictures[] = "/{$path}";
}

?>
<div class="propertyViewSlickFancybox arteastSimplecatalog__propertyView_slickFancybox">
    <div class="propertyViewSlickFancyboxMainArea">
        <div class="jsPropertyViewSlickFancyboxMainArea">
            <?php
            foreach ($pictures as $src) {
                echo "<div class='propertyViewSlickFancyboxMainArea__item'>";
                echo "<a href='{$src}' data-fancybox='jsPropertyViewSlickFancyboxMainArea'><img src='{$src}'></a>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div class="propertyViewSlickFancyboxSmallGalery">
        <div class="jsPropertyViewSlickFancyboxSmallGalery">
            <?php
            foreach ($pictures as $src) {
                echo "<div class='propertyViewSlickFancyboxSmallGalery__item'>";
                echo "<img src='{$src}'>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>
