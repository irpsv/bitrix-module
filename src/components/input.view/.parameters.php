<?php

$arComponentParameters = [
    'PARAMETERS' => [
        'NAME' => [
            'NAME' => 'Имя',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'HINT' => [
            'NAME' => 'Подсказка',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'TYPE' => [
            'NAME' => 'Тип. Доступны: switch, select, flags, textarea, bx_date, bx_datetime, а также все доступные значения атрибута `type` для тэга <input>. Также можно указать полное имя любого компонента, который будет вызван для вывода поля.',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'TYPE_COMPONENT_PARAMS' => [
            'NAME' => 'Список (PHP массив) параметров компонента, который будет вызываться для отображения поля. Для указания шаблона компонента, нужно в данном параметре указать его в элементе `TEMPLATE`',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'ERROR' => [
            'NAME' => 'Текст ошибки (некорректной валидации)',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'SUCCESS' => [
            'NAME' => 'Текст успешной валидации',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'LABEL' => [
            'NAME' => 'Название поля: <label>',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'VALUE' => [
            'NAME' => 'Значение поля',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'VALUES' => [
            'NAME' => 'Список (PHP массив) доступных значений для списочных типов. Допустим как ассоциативный, так и списочный тип массива',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
		'MULTIPLE' => [
            'NAME' => 'Множественное',
            'PARENT' => 'BASE',
			'DEFAULT' => 'N',
            'TYPE' => 'CHECKBOX',
        ],
		'PLACEHOLDER' => [
            'NAME' => 'Предустановленное значение <placeholder>',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
        ],
    ],
];
