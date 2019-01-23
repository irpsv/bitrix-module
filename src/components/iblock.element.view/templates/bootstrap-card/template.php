<?php

include_once __DIR__.'/functions.php';

use bitrix_module\components\classes\templates;

// проброс значений в component_epilog
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

$row = $arResult['ROW'];
$fields = $arParams['FIELDS'] ?? [
	'TOP_IMAGE' => 'PREVIEW_PICTURE',
	'PREVIEW' => 'PREVIEW_TEXT',
	'LINK' => 'DETAIL_PAGE_URL',
	'TITLE' => 'NAME',
];
$header = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, $fields['HEADER']);
$topImage = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, $fields['TOP_IMAGE']);
$title = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, $fields['TITLE']);
$subTitle = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, $fields['SUB_TITLE']);;
$preview = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, $fields['PREVIEW']);
$link = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, $fields['LINK']);;
$footer = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, $fields['FOOTER']);
$bottomImage = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, $fields['BOTTOM_IMAGE']);
$links = $fields['LINKS'] ?? [];
$buttons = $fields['BUTTONS'] ?? [];

$styleClasses = $arParams['CSS_CLASS'] ?? '';

?>
<div id="<?= $arResult['HTML_ID'] ?>" class="bitrix_moduleiblockElementViewBootstrapCard">
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
			$link = $item['LINK'] ?? $row['DETAIL_PAGE_URL'];
			echo "<a href='{$link}' class='card-link'>{$item['TEXT']}</a>";
		}
		foreach ($buttons as $item) {
			$link = $item['LINK'] ?? $row['DETAIL_PAGE_URL'];
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
