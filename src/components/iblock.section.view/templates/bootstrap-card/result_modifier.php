<?php

$row = $arResult['ROW'];
if (!$row) {
    return;
}

//
// SEO
//
$seoValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($row['IBLOCK_ID'], $row['ID']);
$arResult['SEO_VALUES'] = $seoValues->getValues();

//
// BUTTONS
//
$arResult['HTML_ID'] = $this->GetEditAreaId($row['ID']);
$arResult['BUTTONS'] = \CIBlock::GetPanelButtons(
	$row['IBLOCK_ID'],
	false,
	$row['ID']
)['edit'] ?? null;

//
// URLs
//
if ($row['SECTION_PAGE_URL']) {
	$row['SECTION_PAGE_URL'] = \CIBlock::replaceDetailUrl(
	    $row['SECTION_PAGE_URL'],
	    $row,
	    true,
	    'S'
	);
}

if ($row['LIST_PAGE_URL']) {
	$row['LIST_PAGE_URL'] = \CIBlock::replaceDetailUrl(
	    $row['LIST_PAGE_URL'],
	    $row,
	    true,
	    'S'
	);
}

//
// PICTURES
//
if ($row['PICTURE']) {
	$sizes = $arParams['PICTURE_SIZES'] ?? [];
	if ($sizes) {
		$row['PICTURE'] = \CFile::ResizeImageGet($row['PICTURE'], $sizes, \BX_RESIZE_IMAGE_EXACT);
		$row['PICTURE']['SRC'] = $row['PICTURE']['src'];
	}
	else {
		$row['PICTURE'] = \CFile::getFileArray($row['PICTURE']);
	}
	if ($row['PICTURE'] && $arResult['SEO_VALUES']['SECTION_PICTURE_FILE_ALT']) {
		$row['PICTURE']['ALT'] = $arResult['SEO_VALUES']['SECTION_PICTURE_FILE_ALT'];
	}
}

if ($row['DETAIL_PICTURE']) {
	$sizes = $arParams['DETAIL_PICTURE_SIZES'] ?? [];
	if ($sizes) {
		$row['DETAIL_PICTURE'] = \CFile::ResizeImageGet($row['DETAIL_PICTURE'], $sizes, \BX_RESIZE_IMAGE_EXACT);
		$row['DETAIL_PICTURE']['SRC'] = $row['DETAIL_PICTURE']['src'];
	}
	else {
		$row['DETAIL_PICTURE'] = \CFile::getFileArray($row['DETAIL_PICTURE']);
	}
	if ($row['DETAIL_PICTURE'] && $arResult['SEO_VALUES']['SECTION_DETAIL_PICTURE_FILE_ALT']) {
		$row['DETAIL_PICTURE']['ALT'] = $arResult['SEO_VALUES']['SECTION_DETAIL_PICTURE_FILE_ALT'];
	}
}

$arResult['ROW'] = $row;
