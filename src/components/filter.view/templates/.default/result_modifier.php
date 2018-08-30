<?php

\CModule::includeModule('iblock');

$valuesLabels = [];
$attributeValues = $arResult['VALUES'];
foreach ($attributeValues as $values) {
	foreach ($values as $id) {
		$row = \Bitrix\Iblock\PropertyEnumerationTable::getRow([
			'filter' => [
				'=ID' => $id,
			],
		]);
		if ($row) {
			$valuesLabels[$id] = $row['VALUE'];
		}
	}
}

$arResult['VALUES_LABELS'] = $valuesLabels;
unset($valuesLabels, $attributeValues);
