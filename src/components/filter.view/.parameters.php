<?php

$arComponentParameters = [
    'PARAMETERS' => [
        'METHOD' => [
            'NAME' => 'Метод отправки формы',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'FILTER_REQUEST' => [
            'NAME' => 'Экземпляр класса FilterRequest',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'IBLOCK' => [
            'NAME' => 'Список (PHP массив) параметров инфоблока, поля которого используются для фильтра. Содержит поля: ID, CODE, FIELDS (свойства прописываются через PROPERTY_*). Также поле FIELDS может содержить массив поля для компонента `input.view`',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'ACTIVE' => [
            'NAME' => 'Ассоциативный массив, содержащий активный фильтр. Формат: [имя] => [активное значение, либо массив значений]',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'FIELDS' => [
            'NAME' => 'Список (PHP массив) полей. Формат как для компонента `input.view`',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'REQUEST_NAME' => [
            'NAME' => 'Имя фильтра (формы)',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'ONLY_DATA' => [
            'NAME' => 'Флаг показывающий, что фильтр используется только для отображения. Все данные переданные через GET или POST запросы - игнорируются',
            'PARENT' => 'BASE',
			'DEFAULT' => 'Y',
            'TYPE' => 'CHECKBOX',
        ],
    ],
];
