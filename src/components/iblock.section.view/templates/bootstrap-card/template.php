<?php

include_once __DIR__.'/functions.php';

use bitrix_module\components\classes\templates;

// проброс значений в component_epilog
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

$row = $arResult['ROW'];
$fields = $arParams['FIELDS'] ?? [
	'TOP_IMAGE' => 'PICTURE',
	'PREVIEW' => 'DESCRIPTION',
	'LINK' => 'SECTION_PAGE_URL',
	'TITLE' => 'NAME',
];
$header = templates\componentIblockSectionViewGetFieldValue($row, $fields['HEADER']);
$topImage = templates\componentIblockSectionViewGetFieldValue($row, $fields['TOP_IMAGE']);
$title = templates\componentIblockSectionViewGetFieldValue($row, $fields['TITLE']);
$subTitle = templates\componentIblockSectionViewGetFieldValue($row, $fields['SUB_TITLE']);;
$preview = templates\componentIblockSectionViewGetFieldValue($row, $fields['PREVIEW']);
$link = templates\componentIblockSectionViewGetFieldValue($row, $fields['LINK']);;
$footer = templates\componentIblockSectionViewGetFieldValue($row, $fields['FOOTER']);
$bottomImage = templates\componentIblockSectionViewGetFieldValue($row, $fields['BOTTOM_IMAGE']);
$links = $fields['LINKS'] ?? [];
$buttons = $fields['BUTTONS'] ?? [];

$styleClasses = $arParams['CSS_CLASS'] ?? '';

?>
<div id="<?= $arResult['HTML_ID'] ?>" class="modelElementView modelElementView_bootstrapCard">
    <div class="card <?= $styleClasses ?>">
		<?php
		if ($topImage) {
			echo "<a href='{$link}'>
			<img class='card-img-top' src='{$topImage['SRC']}' alt='{$topImage['ALT']}'>
			</a>";
		}
		if ($header) {
			echo "<div class='card-header'>{$header}</div>";
		}

		echo "<div class='card-body'>";
		if ($title) {
			echo "<h5 class='card-title'>{$title}</h5>";
		}
		if ($subTitle) {
			echo "<h6 class='card-subtitle mb-2 text-muted'>{$subTitle}</h6>";
		}
		if ($preview) {
			echo "<p class='card-text'>{$preview}</p>";
		}
		foreach ($links as $item) {
			$link = $item['LINK'] ?? $row['SECTION_PAGE_URL'];
			echo "<a href='{$link}' class='card-link'>{$item['TEXT']}</a>";
		}
		foreach ($buttons as $item) {
			$link = $item['LINK'] ?? $row['SECTION_PAGE_URL'];
			echo "<a href='{$link}' class='btn btn-primary'>{$item['TEXT']}</a>";
		}
		echo "</div>";

		if ($footer) {
			echo "<div class='card-footer'>{$footer}</div>";
		}
		if ($bottomImage) {
			echo "<img class='card-img-top' src='{$bottomImage['SRC']}' alt='{$bottomImage['ALT']}'>";
		}
		?>
    </div>
</div>
