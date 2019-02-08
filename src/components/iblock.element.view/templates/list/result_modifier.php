<?php

$row = $arResult['ROW'];
if (!$row) {
    return;
}

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
// URLs
//
if ($row['DETAIL_PAGE_URL']) {
	$row['DETAIL_PAGE_URL'] = \CIBlock::replaceDetailUrl(
	    $row['DETAIL_PAGE_URL'],
	    $row,
	    true,
	    'E'
	);
}

//
// PICTURES
//
if ($row['PREVIEW_PICTURE']) {
	$sizes = $arParams['PREVIEW_PICTURE_SIZES'] ?? [
        'width' => 500,
        'height' => ceil(500 / 1.618),
    ];

    $row['PREVIEW_PICTURE'] = \CFile::getFileArray($row['PREVIEW_PICTURE']);
	if ($sizes) {
        if ($sizes['width'] > $row['PREVIEW_PICTURE']['WIDTH']) {
            $k = $row['PREVIEW_PICTURE']['WIDTH'] / $sizes['width'];
            $sizes['width'] *= $k;
            $sizes['height'] *= $k;
        }
        else if ($sizes['height'] > $row['PREVIEW_PICTURE']['HEIGHT']) {
            $k = $row['PREVIEW_PICTURE']['HEIGHT'] / $sizes['height'];
            $sizes['width'] *= $k;
            $sizes['height'] *= $k;
        }
		$row['PREVIEW_PICTURE'] = \CFile::ResizeImageGet($row['PREVIEW_PICTURE'], $sizes, \BX_RESIZE_IMAGE_EXACT);
		$row['PREVIEW_PICTURE']['SRC'] = $row['PREVIEW_PICTURE']['src'];
	}
	if ($row['PREVIEW_PICTURE'] && $arResult['SEO_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT']) {
		$row['PREVIEW_PICTURE']['ALT'] = $arResult['SEO_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT'];
	}
}

$arResult['ROW'] = $row;
