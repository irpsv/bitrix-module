<?php

// проброс переменных в component_epilog.php
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

// логика
$dataSet = $arResult['DATA_SET'];

// визуал
$cssClass = (string) ($arParams['CSS_CLASS'] ?? '');
$items = $dataSet->getItems();
$itemTemplate = (string) ($arParams['ITEM_TEMPLATE'] ?? '');
$itemDefaultParams = (array) ($arParams['ITEM_PARAMS'] ?? []);

echo "<div id='{$templateData['HTML_ID']}' class='{$cssClass}'>";
foreach ($items as $item) {
	$itemParams = array_merge(
		[
			'ID' => $item['ID'],
			'CACHE_TYPE' => 'N',
		],
		$itemDefaultParams
	);
	$APPLICATION->IncludeComponent('bitrix.module:iblock.element.view', $itemTemplate, $itemParams, $component);
}
echo "</div>";
