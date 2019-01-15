<?php

$arTemplateParameters = [
    'PARAMETERS' => [
        'REQUIRED' => [
            'NAME' => 'Обязательное',
            'PARENT' => 'VISUAL',
			'DEFAULT' => 'N',
            'TYPE' => 'CHECKBOX',
        ],
		'READONLY' => [
			'NAME' => 'Только для чтения',
            'PARENT' => 'VISUAL',
			'DEFAULT' => 'N',
            'TYPE' => 'CHECKBOX',
        ],
		'GROUP_CSS_CLASS' => [
            'NAME' => 'CSS класс для обертки поля',
			'PARENT' => 'VISUAL',
			'DEFAULT' => 'form-group',
            'TYPE' => 'STRING',
        ],
		'INPUT_CSS_CLASS' => [
            'NAME' => 'CSS класс для поля',
			'PARENT' => 'VISUAL',
			'DEFAULT' => 'form-control',
            'TYPE' => 'STRING',
        ],
		'ATTRIBUTES' => [
            'NAME' => 'Список (PHP массив) атрибутов. Атрибуты `style` и `data` могут также быть массивами (без дополнительных вложений), при выводе сформируется корректный код',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
    ],
];
