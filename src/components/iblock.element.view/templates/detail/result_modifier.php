<?php

global $DB;

$row = $arResult['ROW'];
if (!$row) {
    return;
}

//
// SECTION_TREE
//
$sectionTree = [];
$nowSection = \CIBlockSection::getList([
    'DEPTH_LEVEL' => 'DESC',
], [
	'IBLOCK_ID' => $row['IBLOCK_ID'],
    'HAS_ELEMENT' => $row['ID'],
    'CHECK_PERMISSIONS' => 'N',
])->fetch();
$limit = 10;
while ($limit-- && $nowSection) {
	$nowSection['SECTION_PAGE_URL'] = \CIBlock::replaceSectionUrl(
		$nowSection['SECTION_PAGE_URL'],
		$nowSection,
		false,
		'S'
	);
	array_unshift($sectionTree, $nowSection);

	$nowSectionId = $nowSection['IBLOCK_SECTION_ID'];
	if ($nowSectionId) {
		$nowSection = \CIBlockSection::getList([], [
			'ID' => $nowSectionId,
			'IBLOCK_ID' => $nowSection['IBLOCK_ID'],
			'CHECK_PERMISSIONS' => 'N',
		])->fetch();
	}
	else {
		$nowSection = false;
	}
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
// CANONICAL
//
$arResult['CANONICAL'] = \CIBlock::replaceDetailUrl(
    $row['CANONICAL_PAGE_URL'],
    $row,
    true,
    'E'
);

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
if ($row['DETAIL_PICTURE']) {
	$sizes = $arParams['DETAIL_PICTURE_SIZES'] ?? [];

    $row['DETAIL_PICTURE'] = \CFile::getFileArray($row['DETAIL_PICTURE']);
	if ($sizes) {
        $originalWidth = $row['DETAIL_PICTURE']['WIDTH'];
        $originalHeight = $row['DETAIL_PICTURE']['HEIGHT'];

        $isWidthGreater = $sizes['width'] > $originalWidth;
        $isHeightGreater = $sizes['height'] > $originalHeight;

        $k = 1;
        if ($isWidthGreater && $isHeightGreater) {
            if ($originalHeight > $originalWidth) {
                $k = $originalWidth / $sizes['width'];
            }
            else {
                $k = $originalHeight / $sizes['height'];
            }
        }
        else if ($isWidthGreater) {
            $k = $originalWidth / $sizes['width'];
        }
        else if ($isHeightGreater) {
            $k = $originalHeight / $sizes['height'];
        }
        $sizes['width'] *= $k;
        $sizes['height'] *= $k;

		$row['DETAIL_PICTURE'] = \CFile::ResizeImageGet($row['DETAIL_PICTURE'], $sizes, \BX_RESIZE_IMAGE_EXACT);
		$row['DETAIL_PICTURE']['SRC'] = $row['DETAIL_PICTURE']['src'];
	}
	if ($row['DETAIL_PICTURE'] && $arResult['SEO_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']) {
		$row['DETAIL_PICTURE']['ALT'] = $arResult['SEO_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'];
	}
	if ($row['DETAIL_PICTURE'] && $arResult['SEO_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']) {
		$row['DETAIL_PICTURE']['TITLE'] = $arResult['SEO_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'];
	}
}

$arResult['ROW'] = $row;

//
// PROPS
//
$props = [];
$propsCodes = [
	// 'code',
];
if ($propsCodes) {
	$propResult = \CIBlockElement::getProperty(
		$row['IBLOCK_ID'],
		$row['ID'],
		[],
		[
			'CODE' => $propsCodes,
		]
	);
	while ($propRow = $propResult->fetch()) {
		$code = $propRow['CODE'];
		$value = $propRow['VALUE'];
		if ($propRow['MULTIPLE'] === 'Y') {
			$value = (array) $value;
			if (isset($props[$code])) {
				array_push($props[$code], ...$value);
				continue;
			}
		}
		$props[$code] = $value;
	}
}
$arResult['PROPS'] = $props;
