\CModule::includeModule('bitrix.module');

$builder = new \bitrix_module\builder\general\BuildModule;
$builder->savedDir = $_SERVER['DOCUMENT_ROOT'].'/local/modules/bitrix.module/install/';
$builder->saveFiles = [
	''
];
$builder->iblockTypes = [
	'bitrix_module',
];
$builder->build();
