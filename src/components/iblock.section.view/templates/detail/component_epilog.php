<?php

global $APPLICATION;

$sectionTree = $templateData['SECTION_TREE'] ?? [];
foreach ($sectionTree as $row) {
    $APPLICATION->AddChainItem($row['NAME'], $row['SECTION_PAGE_URL']);
}

$row = $templateData['ROW'];
$seo = $templateData['SEO_VALUES'];
if ($seo['SECTION_META_DESCRIPTION']) {
    $APPLICATION->SetPageProperty('description', $seo['SECTION_META_DESCRIPTION']);
}
if ($seo['SECTION_META_KEYWORDS']) {
    $APPLICATION->SetPageProperty('keywords', $seo['SECTION_META_KEYWORDS']);
}

$rowName = $row['NAME'] ?: null;
if ($rowName) {
	$APPLICATION->SetTitle($rowName);
}

$title = $seo['SECTION_META_TITLE'] ?? $rowName;
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
// OPEN GRAPH & CANONICAL
//
if ($templateData['CANONICAL']) {
    $value = htmlspecialchars($templateData['CANONICAL']);
    $APPLICATION->AddHeadString("<link rel='canonical' href='{$value}'/>");
    $APPLICATION->AddHeadString("<meta property='og:url' content='{$value}'/>");
}
if ($templateData['OPEN_GRAPH_TITLE']) {
    $value = htmlspecialchars($templateData['OPEN_GRAPH_TITLE']);
    $APPLICATION->AddHeadString("<meta property='og:title' content='{$value}'/>");
}
if ($templateData['OPEN_GRAPH_DESCRIPTION']) {
    $value = htmlspecialchars($templateData['OPEN_GRAPH_DESCRIPTION']);
    $APPLICATION->AddHeadString("<meta property='og:description' content='{$value}'/>");
}
if ($templateData['OPEN_GRAPH_IMAGE']) {
    $value = htmlspecialchars($templateData['OPEN_GRAPH_IMAGE']);
    $APPLICATION->AddHeadString("<meta property='og:image' content='{$value}'/>");
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
            'TITLE' => $buttons['edit_section']['TITLE'],
            'URL' => 'javascript:'.$APPLICATION->getPopupLink([
                'URL' => $buttons['edit_section']['ACTION_URL'],
                "PARAMS" => [
                    "width" => 780,
    				"height" => 500,
                ],
            ]),
        ],
        [
            'ICON' => 'bx-context-toolbar-delete-icon',
            'TITLE' => $buttons['delete_section']['TITLE'],
            'URL' => "javascript:if(confirm('Вы уверены что хотите удалить?')) jsUtils.Redirect([], '{$deleteLink}');",
        ]
    ]);
}
