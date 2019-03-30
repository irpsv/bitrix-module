<?php

$row = $arResult['ROW'];
if (!$row) {
    return;
}

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

$arResult['ROW'] = $row;
