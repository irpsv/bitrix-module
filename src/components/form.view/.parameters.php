<?php

$arComponentParameters = [
    'PARAMETERS' => [
        'FIELDS' => [
            'NAME' => 'Список (PHP массив) полей формы. Набор полей для одного элемента идентичен компоненту `input.view`',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'METHOD' => [
            'NAME' => 'Метод формы',
			'PARENT' => 'BASE',
            'DEFAULT' => 'POST',
            'TYPE' => 'STRING',
        ],
		'FORM_NAME' => [
            'NAME' => 'Имя формы',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'ACTION_URL' => [
            'NAME' => 'URL оброботчика формы',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
    ],
];
