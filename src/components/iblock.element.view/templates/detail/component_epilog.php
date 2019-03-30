<?php

global $APPLICATION;

$sectionTree = $templateData['SECTION_TREE'] ?? [];
foreach ($sectionTree as $row) {
    $APPLICATION->AddChainItem($row['NAME'], $row['SECTION_PAGE_URL']);
}

$row = $templateData['ROW'];
if ($row) {
    \CModule::includeModule('iblock');
    \CIBlockElement::CounterInc($row['ID']);
}

$seo = $templateData['SEO_VALUES'];
if ($seo['ELEMENT_META_DESCRIPTION']) {
    $APPLICATION->SetPageProperty('description', $seo['ELEMENT_META_DESCRIPTION']);
}
if ($seo['ELEMENT_META_KEYWORDS']) {
    $APPLICATION->SetPageProperty('keywords', $seo['ELEMENT_META_KEYWORDS']);
}

$rowName = $row['NAME'] ?: null;
if ($rowName) {
	$APPLICATION->SetTitle($rowName);
}

$title = $seo['ELEMENT_META_TITLE'] ?? $rowName;
if ($title) {
    $APPLICATION->SetPageProperty('title', $title);
    if ($rowName) {
        $APPLICATION->AddChainItem($rowName);
    }
    else {
        $APPLICATION->AddChainItem($title);
    }
}

//
// CANONICAL
//
if ($templateData['CANONICAL']) {
    $value = htmlspecialchars($templateData['CANONICAL'], ENT_QUOTES | ENT_HTML401);
    $APPLICATION->AddHeadString("<link rel='canonical' href='{$value}'/>");
}

$areaId = $templateData['HTML_ID'] ?? null;
$buttons = $templateData['BUTTONS'] ?? null;

// не искользуются стандартные,
// тк при вызове из родительского компонента,
// не совпадают AreaId (генерация проводится от имени родительского компонента)
if ($areaId && $buttons) {
    $deleteLink = $buttons['delete_element']['ACTION_URL'] ."&return_url=".urlencode($APPLICATION->getCurPageParam());
    $APPLICATION->setEditArea($areaId, [
        [
            'ICON' => 'bx-context-toolbar-edit-icon',
            'TITLE' => $buttons['edit_element']['TITLE'],
            'URL' => 'javascript:'.$APPLICATION->getPopupLink([
                'URL' => $buttons['edit_element']['ACTION_URL'],
                "PARAMS" => [
                    "width" => 780,
    				"height" => 500,
                ],
            ]),
        ],
        [
            'ICON' => 'bx-context-toolbar-delete-icon',
            'TITLE' => $buttons['delete_element']['TITLE'],
            'URL' => "javascript:if(confirm('Вы уверены что хотите удалить?')) jsUtils.Redirect([], '{$deleteLink}');",
        ]
    ]);
}
