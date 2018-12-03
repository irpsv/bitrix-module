<?php

$model = $arResult['MODEL'];
$element = \CIBlockElement::getById($model->id)->fetch();
if (!$element) {
    return;
}
$arResult['ELEMENT'] = $element;

//
// SECTION_TREE
//
$sectionTree = [];
$result = \CIBlockSection::getList([
    'DEPTH_LEVEL' => 'ASC',
], [
    'HAS_ELEMENT' => $element['ID'],
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
$seoValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($element['IBLOCK_ID'], $element['ID']);
$arResult['SEO_VALUES'] = $seoValues->getValues();

//
// BUTTONS
//
$arResult['HTML_ID'] = $this->GetEditAreaId($element['ID']);
$arResult['BUTTONS'] = \CIBlock::GetPanelButtons(
	$element['IBLOCK_ID'],
	$element['ID'],
	$element['IBLOCK_SECTION_ID']
)['edit'] ?? null;

//
// OPEN GRAPH & CANONICAL
//
$arResult['CANONICAL'] = \CIBlock::replaceDetailUrl(
    $element['CANONICAL_PAGE_URL'],
    $element,
    true,
    'E'
);
$arResult['OPEN_GRAPH_TITLE'] = $arResult['SEO_VALUES']['ELEMENT_META_TITLE'] ?? $element['NAME'];
$arResult['OPEN_GRAPH_DESCRIPTION'] = $arResult['SEO_VALUES']['ELEMENT_META_DESCRIPTION'] ?? null;
$arResult['OPEN_GRAPH_IMAGE'] = null;

$imageId = $element['DETAIL_PICTURE'] ?: $element['PREVIEW_PICTURE'];
if ($imageId) {
    $src = \CFile::GetPath($imageId);
    if ($src) {
        $scheme = $_SERVER['REQUEST_SCHEME'] ?: 'http';
        $arResult['OPEN_GRAPH_IMAGE'] = "{$scheme}://". \SITE_SERVER_NAME .$src;
    }
}
