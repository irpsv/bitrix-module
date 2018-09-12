# IblockSection

Компоненты:
- iblock.section.list
- iblock.section.view

## Примеры

```php
$APPLICATION->IncludeComponent("bitrix_module:iblock.section.list", "", [
	// для СТАРОГО ядра параметры
	'IBLOCK' => [
		'ORDER' => [
			'SORT' => 'ASC',
		],
		'FILTER' => [
			'ID' => 171,
		],
		'ELEMENT_CNT' => true,
		'NAV' => [
			'nTopCount' => 100,
		],
		'SELECT' => [
			'ID',
			'NAME',
		],
	],
	// шаблон компонента iblock.section.view
	'ITEM_TEMPLATE' => '',
]);

$APPLICATION->IncludeComponent("bitrix_module:iblock.section.view", "", [
	'ROW' => [
		'NAME' => 'fakeSection',
	],
]);

$APPLICATION->IncludeComponent("bitrix_module:iblock.section.view", "", [
	'ID' => '171',
]);

$APPLICATION->IncludeComponent("bitrix_module:iblock.section.view", "", [
	'FILTER' => [
		'ID' => '171',
	],
]);
```
