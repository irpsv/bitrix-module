<?php

$arTemplateParameters = [
    'PARAMETERS' => [
        'IS_AJAX_SEND' => [
            'NAME' => 'Отправлять форму по AJAX',
			'PARENT' => 'VISUAL',
			'DEFAULT' => 'Y',
            'TYPE' => 'CHECKBOX',
        ],
		'IS_BITRIX_SESSID_CHECK' => [
            'NAME' => 'Использовтаь проверку Bitrix sessid',
            'PARENT' => 'VISUAL',
			'DEFAULT' => 'Y',
            'TYPE' => 'CHECKBOX',
        ],
		'FORM_CSS_CLASS' => [
            'NAME' => 'CSS класс формы',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
		'GROUP_CSS_CLASS' => [
            'NAME' => 'CSS класс обертки поля (передается в компонент `input.view`)',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
		'INPUT_CSS_CLASS' => [
			'NAME' => 'CSS класс поля (передается в компонент `input.view`)',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
		'SUCCESS_TEXT' => [
            'NAME' => 'Текст при успешной отправке формы по AJAX',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
		'BUTTONS' => [
            'NAME' => 'Список (PHP массив) кнопок, выводимых в форме',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
		'AGREEMENT_ID' => [
            'NAME' => 'ИД согласия на обработку данных',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
		'AGREEMENT_LINK' => [
            'NAME' => 'Ссылка на страницу с согласием обработки данных',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
		'AGREEMENT_TEXT' => [
            'NAME' => 'Текст выводимый в форме для принятия согласия',
            'PARENT' => 'VISUAL',
            'TYPE' => 'STRING',
        ],
    ],
];
