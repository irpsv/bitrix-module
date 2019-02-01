# Пример использования

```php
\CModule::includeModule('build_module');

$builder = new \build_module\general\BuildModule;
$builder->savedDir = $_SERVER['DOCUMENT_ROOT'].'/local/modules/build.module/install/';
$builder->saveFiles = [
	'/about/vacansii'
];
$builder->iblockTypes = [
	'build_module',
];
$builder->build();
```
