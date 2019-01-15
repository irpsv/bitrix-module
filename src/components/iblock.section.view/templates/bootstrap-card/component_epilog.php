<?php

global $APPLICATION;

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
