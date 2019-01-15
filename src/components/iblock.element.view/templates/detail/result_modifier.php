<?php

$row = $arResult['ROW'];
if (!$row) {
    return;
}

//
// SECTION_TREE
//
$sectionTree = [];
$result = \CIBlockSection::getList([
    'DEPTH_LEVEL' => 'ASC',
], [
	'IBLOCK_ID' => $row['IBLOCK_ID'],
    'HAS_ELEMENT' => $row['ID'],
    'CHECK_PERMISSIONS' => 'N',
]);
while ($section = $result->fetch()) {
    $section['SECTION_PAGE_URL'] = \CIBlock::replaceSectionUrl($section['SECTION_PAGE_URL'], $section, false, 'S');
    $sectionTree[] = $section;
}
$arResult['SECTION_TREE'] = $sectionTree;

//
// SEO
//
$seoValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($row['IBLOCK_ID'], $row['ID']);
$arResult['SEO_VALUES'] = $seoValues->getValues();

//
// BUTTONS
//
$arResult['HTML_ID'] = $this->GetEditAreaId($row['ID']);
$arResult['BUTTONS'] = \CIBlock::GetPanelButtons(
	$row['IBLOCK_ID'],
	$row['ID'],
	$row['IBLOCK_SECTION_ID']
)['edit'] ?? null;

//
// OPEN GRAPH & CANONICAL
//
$arResult['CANONICAL'] = \CIBlock::replaceDetailUrl(
    $row['CANONICAL_PAGE_URL'],
    $row,
    true,
    'E'
);
$arResult['OPEN_GRAPH_TITLE'] = $arResult['SEO_VALUES']['ELEMENT_META_TITLE'] ?? $row['NAME'];
$arResult['OPEN_GRAPH_DESCRIPTION'] = $arResult['SEO_VALUES']['ELEMENT_META_DESCRIPTION'] ?? null;
$arResult['OPEN_GRAPH_IMAGE'] = null;

//
// URLs
//
if ($row['SECTION_PAGE_URL']) {
	$row['SECTION_PAGE_URL'] = \CIBlock::replaceDetailUrl(
	    $row['SECTION_PAGE_URL'],
	    $row,
	    true,
	    'E'
	);
}

if ($row['DETAIL_PAGE_URL']) {
	$row['DETAIL_PAGE_URL'] = \CIBlock::replaceDetailUrl(
	    $row['DETAIL_PAGE_URL'],
	    $row,
	    true,
	    'E'
	);
}

if ($row['LIST_PAGE_URL']) {
	$row['LIST_PAGE_URL'] = \CIBlock::replaceDetailUrl(
	    $row['LIST_PAGE_URL'],
	    $row,
	    true,
	    'E'
	);
}

//
// PICTURES
//
if ($row['PREVIEW_PICTURE']) {
	$sizes = $arParams['PREVIEW_PICTURE_SIZES'] ?? [];
	if ($sizes) {
		$row['PREVIEW_PICTURE'] = \CFile::ResizeImageGet($row['PREVIEW_PICTURE'], $sizes, \BX_RESIZE_IMAGE_EXACT);
		$row['PREVIEW_PICTURE']['SRC'] = $row['PREVIEW_PICTURE']['src'];
	}
	else {
		$row['PREVIEW_PICTURE'] = \CFile::getFileArray($row['PREVIEW_PICTURE']);
	}
	if ($row['PREVIEW_PICTURE'] && $arResult['SEO_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']) {
		$row['PREVIEW_PICTURE']['ALT'] = $arResult['SEO_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT'];
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
	if ($row['DETAIL_PICTURE'] && $arResult['SEO_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']) {
		$row['DETAIL_PICTURE']['ALT'] = $arResult['SEO_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'];
	}
}

$imageId = $row['DETAIL_PICTURE'] ?: $row['PREVIEW_PICTURE'];
if ($imageId) {
    $src = \CFile::GetPath($imageId);
    if ($src) {
        $scheme = $_SERVER['REQUEST_SCHEME'] ?: 'http';
        $arResult['OPEN_GRAPH_IMAGE'] = "{$scheme}://". \SITE_SERVER_NAME .$src;
    }
}

$arResult['ROW'] = $row;
