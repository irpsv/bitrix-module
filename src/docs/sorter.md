# Sorter

Классы:
- \\bitrix_module\\data\\Sorter
- \\bitrix_module\\data\\SorterRequest
- \\bitrix_module\\data\\SorterRequestBuildByComponentParams

Компоненты:
- sorter.view

## Примеры

```php

$APPLICATION->IncludeComponent("bitrix_module:sorter.view", "", [
	'FIELDS' => [
		'ID',
		'NAME',
		'PRICE',
	],
]);

$APPLICATION->IncludeComponent("bitrix_module:sorter.view", "", [
	'FIELDS' => [
		'ID',
		'NAME' => 'Лэйбэл',
		'PRICE',
	],
	'ACTIVE' => [
		'PRICE' => 'asc',
	],
]);
```
