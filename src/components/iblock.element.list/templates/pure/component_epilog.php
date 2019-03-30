<?php

global $APPLICATION;

$areaId = $templateData['HTML_ID'] ?? null;
$buttons = $templateData['BUTTONS'] ?? null;

// не искользуются стандартные,
// тк при вызове из родительского компонента,
// не совпадают AreaId (генерация проводится от имени родительского компонента)
if ($areaId && $buttons) {
    $APPLICATION->setEditArea($areaId, [
        [
            'ICON' => 'bx-context-toolbar-edit-icon',
            'TITLE' => $buttons['add_element']['TITLE'],
            'URL' => 'javascript:'.$APPLICATION->getPopupLink([
                'URL' => $buttons['add_element']['ACTION_URL'],
                "PARAMS" => [
                    "width" => 780,
    				"height" => 500,
                ],
            ]),
        ],
    ]);
}
