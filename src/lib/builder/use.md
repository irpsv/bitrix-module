# Пример использования

```php
\CModule::includeModule('build_module');

$builder = new \build_module\general\BuildModule;
$builder->savedDir = $_SERVER['DOCUMENT_ROOT'].'/local/modules/arteast.vacancy/install/';
$builder->saveFiles = [
	'/about/vacansii'
];
$builder->iblockTypes = [
	'arteast_vacancy',
];
$builder->build();
```
