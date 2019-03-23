<?php

$arTemplateParameters = [
    'PAGER_TEMPLATE' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Шаблон пагинатора',
        'TYPE' => 'STRING',
    ],
    'SORTER_TEMPLATE' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Шаблон сортировщика',
        'TYPE' => 'STRING',
    ],
    'FILTER_TEMPLATE' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Шаблон фильтра',
        'TYPE' => 'STRING',
    ],
    'ITEM_TEMPLATE' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Шаблон элемента',
        'DEFAULT' => 'grid',
        'TYPE' => 'STRING',
    ],
    'COLS' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Столбцов',
        'TYPE' => 'LIST',
        'DEFAULT' => '3',
        'VALUES' => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ],
    ],
];
