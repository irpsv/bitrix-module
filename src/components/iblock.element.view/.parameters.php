<?php

$arComponentParameters = [
    'PARAMETERS' => [
        'PROCESS_404' => [
            'NAME' => 'Вызывать 404 ошибку при пустом результате',
            'PARENT' => 'BASE',
            'TYPE' => 'CHECKBOX',
        ],
        'ID' => [
            'NAME' => 'Идентификатор элемента',
            'PARENT' => 'DATA_SOURCE',
            'TYPE' => 'STRING',
        ],
        'FILTER' => [
            'NAME' => 'Значения фильтра (массив)',
            'PARENT' => 'DATA_SOURCE',
            'TYPE' => 'STRING',
        ],
    ],
];
