# bitrix-module
Шаблон структуры модуля

## TODO

- добавить Pager + компонент
- добавить Sorter + компонент
- добавить Filter + компонент
- добавить компонент списка (с использованием фильтра, сортировки и пагинатора), выделить в отдельный trait (или лучше класс?), чтобы можно было пихать в любом компонент
- добавить компонент form.view и form.validate

```php
// выводит форму
$APPLICATION->IncludeModule('form.view', 'bootstrap', [
	'METHOD' => 'post', // по-умолчанию
	'FORM_NAME' => 'form1', // если не указан - генерируется
	'MODEL' => array|callback, // ассоциативный массив
	'FIELDS' => [
		'name' => 'label',
		[
			'name' => '...',
			'hint' => '...',
			'label' => '...',
			'options' => [
				'html' => 'attributes',
			],
		]
	],
	'USE_CAPTCHA' => 'Y', // по сути зависит от шаблона
]);


// возвращает массив (по факту скатывается к вызову стандартного апи, если такое существует)
$result = $APPLICATION->IncludeModule('form.validate', 'bootstrap', [
	'METHOD' => 'post', // по-умолчанию
	'FORM_NAME' => 'form1', // если не указан - генерируется
	'FIELDS' => [
		'name' => 'label',
		[
			'name' => '...',
			'hint' => '...',
			'label' => '...',
			'options' => [
				'html' => 'attributes',
			],
		]
	],
	'USE_CAPTCHA' => 'Y',
]);
$result['MODEL']; // ассоциативный массив с заполнеными параметрами
$result['ERRORS']; // список ошибок
```
