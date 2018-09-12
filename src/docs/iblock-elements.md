# IblockElements

Компоненты:
- iblock.element.list
- iblock.element.view

## Примеры

Параметры `IBLOCK` содержит параметры для СТАРОГО ядра, т.е. для метода `\CIBlockElement::getList`.
Минимальный код вызова:
```php
$APPLICATION->IncludeComponent("bitrix_module:iblock.element.list", "", [
	'IBLOCK' => [
		'FILTER' => [
			'IBLOCK_ID' => 41,
		],
		// 'SELECT' => [
		// 	'NAME',
		// ],
		// 'ORDER' => [
		// 	'SORT' => 'ASC',
		// ],
		// 'GROUP' => [
		// 	'ID',
		// ],
		// 'NAV' => [
		// 	'nTopCount' => 10,
		// ],
	],
]);
```

Указание настроек для фильтра, сортировки и пагинации:
```php
$APPLICATION->IncludeComponent("bitrix_module:iblock.element.list", "", [
	// параметры для компонента pager.view
	// параметр TOTAL_COUNT подставляетя "на лету", поэтому не нужно его указывать
	'PAGER_PARAMS' => [
		'PAGE_SIZE' => 10,
		'PAGES_VIEWED_COUNT' => 9,
	],
	'PAGER_TEMPLATE' => '',
	// параметры для компонента sorter.view
	'SORTER_PARAMS' => [
		'FIELDS' => [
			'ID',
			'NAME' => 'Лэйбэл',
			'PRICE',
		],
		'ACTIVE' => [
			'PRICE' => 'asc',
		],
	],
	'SORTER_TEMPLATE' => '',
	// параметры для компонента filter.view
	'FILTER_PARAMS' => [
		'IBLOCK' => [
			'ID' => 41,
			'FIELDS' => [
				'DATE_CREATE',
				'NAME',
				'PROPERTY_OS',
				'PROPERTY_331',
			],
		],
	],
	'FILTER_TEMPLATE' => '',
	// для СТАРОГО ядра параметры (имеют больший приоритет поэтому переопределяют выше указанные параметры)
	'IBLOCK' => [
		'FILTER' => [
			'IBLOCK_ID' => 41,
		],
		'SELECT' => [
			'ID',
		],
	],
	// шаблон для компонента iblock.element.view
	'ITEM_TEMPLATE' => '',
]);
```

Просмотр элемента инфоблока:
```php
$APPLICATION->IncludeComponent("bitrix_module:iblock.element.view", "", [
	'ROW' => [
		'NAME' => 'fakeElement',
	],
]);

$APPLICATION->IncludeComponent("bitrix_module:iblock.element.view", "", [
	'ID' => '74542',
]);

$APPLICATION->IncludeComponent("bitrix_module:iblock.element.view", "", [
	'FILTER' => [
		'ID' => '74542',
	],
]);
```

В любом случае, кеширование происходит по идентификатору элемента.
