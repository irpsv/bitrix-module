<?php

\CModule::includeModule('iblock');

//
// iblock type
//
$iblockTypeId = "module_id_preffix";
if (\CIBlockType::getById($iblockTypeId)->selectedRowsCount() < 1) {
	$iblockType = new \CIBlockType;
	$iblockType->Add([
		'ID' => $iblockTypeId,
		'SECTIONS' => 'Y',
		'IN_RSS' => 'N',
		'SORT' => '500',
		'LANG' => [
			'ru' => [
				'NAME' => '',
				'SECTION_NAME' => 'Разделы',
				'ELEMENT_NAME' => 'Элементы',
			],
		],
	]);
	if ($iblockType->LAST_ERROR) {
		throw new \Exception($iblockType->LAST_ERROR);
	}
}

//
// iblock
//
$iblockCode = "module_id_preffix";
$filter = [
	'CODE' => $iblockCode,
	'IBLOCK_TYPE_ID' => $iblockTypeId,
];
$iblock = \CIBlock::getList([], $filter)->fetch();
if ($iblock) {
	$iblockId = $iblock['ID'];
}
else {
	$iblock = new \CIBlock;
	$iblockId = $iblock->Add([
		'LID' => \SITE_ID,
		'NAME' => '',
		'CODE' => $iblockCode,
		'IBLOCK_TYPE_ID' => $iblockTypeId,
		'BIZPROC' => 'N',
		'WORKFLOW' => 'N',
	]);
	if ($iblock->LAST_ERROR) {
		throw new \Exception($iblock->LAST_ERROR);
	}
}

//
// iblock property
//
$propertyCode = "module_id_preffix";
$filter = [
	'CODE' => $propertyCode,
	'IBLOCK_ID' => $iblockId,
];
$property = \CIBlockProperty::getList([], $filter)->fetch();
if ($property) {
	$propertyId = $property['ID'];
}
else {
	$property = new \CIBlockProperty;
	$propertyId = $property->Add([
		'NAME' => '',
		'CODE' => $propertyCode,
		'IBLOCK_ID' => $iblockId,
		'PROPERTY_TYPE' => 'S',
		'PROPERTY_TYPE' => 'N',
		'PROPERTY_TYPE' => 'F',
		'PROPERTY_TYPE' => 'E',
		'PROPERTY_TYPE' => 'G',
		// 'USER_TYPE' => 'user_type',
		// 'USER_TYPE_SETTINGS' => serialize([]),
	]);
	if ($property->LAST_ERROR) {
		throw new \Exception($property->LAST_ERROR);
	}
}

//
// iblock property enum
//
$proprtyValues = [
	"раз",
	"2",
	"three",
];
foreach ($proprtyValues as $propertyValue) {
	$filter = [
		'VALUE' => $propertyValue,
		'PROPERTY_ID' => $propertyId,
	];
	$count = \CIBlockPropertyEnum::getList([], $filter, []);
	if ($count == 0) {
		$row = new \CIBlockPropertyEnum;
		$row->Add([
			'PROPERTY_ID' => $propertyId,
			'VALUE' => $propertyValue,
		]);
		if ($row->LAST_ERROR) {
			throw new \Exception($row->LAST_ERROR);
		}
	}
}
