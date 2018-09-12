# Filter

Классы:
- \\bitrix_module\\data\\Filter
- \\bitrix_module\\data\\FilterField
- \\bitrix_module\\data\\FilterRequest
- \\bitrix_module\\data\\FilterRequestBuildByIblockParams
- \\bitrix_module\\data\\FilterRequestBuildByComponentParams

Компоненты:
- filter.view

## Примеры

Вертикальный фильтр:
```php
$filterRequest = $APPLICATION->IncludeComponent("bitrix_module:filter.view", "", [
	// можно так, а можно сразу в объявлении fields
	'ACTIVE' => [
		'PROPERTY_text' => 'value',
		'PROPERTY_element' => [
			'value3',
			'value4',
			'value5',
		],
	],
	'FIELDS' => [
		[
			'NAME' => 'NAME',
			'LABEL' => 'нАЗВАНИЕ',
			'VALUE' => 'sdfkmsldkfmslkdmfslkdfm',
		],
		[
			'NAME' => 'DETAIL_TEXT',
			'TYPE' => 'componentName',
		],
		[
			'NAME' => 'DATE_CREATE',
			'TYPE' => 'datetime',
		],
		[
			'NAME' => 'PROPERTY_text',
			'TYPE' => 'checkbox',
		],
		[
			'NAME' => 'PROPERTY_list',
			'LABEL' => 'Списокан',
			'VALUES' => [
				'value1' => 'label1',
				'value2' => 'label2',
				'value3' => 'label3',
				'value4' => 'label4',
			],
			'VALUE' => 'value2',
			'MULTIPLE' => false,
		],
		[
			'NAME' => 'PROPERTY_element',
			'TYPE' => 'checkboxlist',
			'multiple' => true,
			'VALUE' => 'value3',
			'VALUES' => [
				'value1',
				'value2',
				'value3',
				'value4',
			],
		],
	],
	'REQUEST_NAME' => 'newFilterName',
]);
```

Вывод для инфоблока:
```php
$filterRequest = $APPLICATION->IncludeComponent("bitrix_module:filter.view", "", [
	'IBLOCK' => [
		'ID' => 41,
		'FIELDS' => [
			'DATE_CREATE',
			'NAME',
			'PROPERTY_OS',
			'PROPERTY_331',
		],
	],
	'ACTIVE' => [
		'NAME' => 'kas',
	],
]);
```

Табличный фильтр:
```php
\CModule::includeModule("bitrix_module");

$iblockId = 41;
$filterRequest = \bitrix_module\data\FilterRequestBuildByIblockParams::runStatic($iblockId, [
	'DATE_CREATE',
	'NAME',
	'PROPERTY_OS',
	'PROPERTY_331',
]);

$filterRequest->filter->getField('PROPERTY_331')->type = "radiolist";
$filterRequest->filter->getField('PROPERTY_OS')->type = "checkboxlist";

$filterRequest->load($_GET);

?>
<form method="get">
	<table>
		<thead>
			<?php
			$APPLICATION->IncludeComponent("bitrix_module:filter.view", "table-row", [
				'FILTER_REQUEST' => $filterRequest,
			]);
			?>
		</thead>
		<tbody>
			<?php
			$filterRows = $filterRequest->filter->getActive();
			?>
		</tbody>
	</table>
</form>
```
