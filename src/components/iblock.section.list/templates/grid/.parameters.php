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
	'COL_XS' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Размер столбца в XS устройствах',
        'TYPE' => 'STRING',
    ],
	'COL_SM' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Размер столбца в SM устройствах',
        'TYPE' => 'STRING',
    ],
	'COL_MD' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Размер столбца в MD устройствах',
        'TYPE' => 'STRING',
    ],
	'COL_LG' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Размер столбца в LG устройствах',
        'TYPE' => 'STRING',
    ],
	'COL_XL' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Размер столбца в XL устройствах',
        'TYPE' => 'STRING',
    ],
	'EMPTY_TEXT' => [
        'PARENT' => 'VISUAL',
        'NAME' => 'Текст при отсутствии элементов',
        'TYPE' => 'STRING',
    ],
];
