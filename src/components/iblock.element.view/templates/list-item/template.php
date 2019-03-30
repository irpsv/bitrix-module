<?php

// проброс значений в component_epilog
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

$row = $arResult['ROW'];
$props = $arResult['PROPS'];

$picture	= $row['PREVIEW_PICTURE'];
$title		= $row['NAME'];
$subTitle	= null;
$preview	= $row['PREVIEW_TEXT'];
$link		= $row['DETAIL_PAGE_URL'];
$links = [];
$buttons = [
	[
		'TEXT' => 'Подробнее',
	],
];

$styleClasses = $arParams['CSS_CLASS'] ?? '';

?>
<div id="<?= $arResult['HTML_ID'] ?>" class="bitrixModuleCssIblockElementViewListItem list-item <?= $styleClasses ?>">
	<?php
	if ($picture) {
		echo "<div class='list-item-img'>";
		if ($link) {
			echo "<a href='{$link}'>
			<img class='w-100' src='{$picture['SRC']}' alt='{$picture['ALT']}' title='{$picture['ALT']}'>
			</a>";
		}
		else {
			echo "<img class='w-100' src='{$picture['SRC']}' alt='{$picture['ALT']}' title='{$picture['ALT']}'>";
		}
		echo "</div>";
	}

	echo "<div class='list-item-body'>";
	if ($title) {
		if ($link) {
			echo "<h5 class='list-item-title'>
			<a href='{$link}'>{$title}</a>
			</h5>";
		}
		else {
			echo "<h5 class='list-item-title'>{$title}</h5>";
		}
	}
	if ($subTitle) {
		echo "<h6 class='list-item-subtitle'>{$subTitle}</h6>";
	}
	if ($preview) {
		echo "<div class='list-item-text'>{$preview}</div>";
	}
	foreach ($links as $item) {
		$link = $item['LINK'] ?? $row['DETAIL_PAGE_URL'];
		echo "<a href='{$link}' class='list-item-link'>{$item['TEXT']}</a>";
	}
	foreach ($buttons as $item) {
		$link = $item['LINK'] ?? $row['DETAIL_PAGE_URL'];
		echo "<a href='{$link}' class='btn btn-primary'>{$item['TEXT']}</a>";
	}
	echo "</div>";
	?>
</div>
