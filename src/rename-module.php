<?php

$names = [
    // название модуля (используется в описании модуля и компонентов)
    'bitrix_module_name' => '',
    // дата модуля
    'bitrix_module_date' => date('Y-m-d'),
    // namespace модуля
    'bitrix_module' => '',
    // название модуля в битрикс
    'bitrix.module' => '',
	// именя CSS классов
	'bitrixModuleCss' => '',
];
$exts = [
	"js",
    "php",
	"css",
];
$exclude = [
    ".",
    "..",
    "rename-module.php",
];

$baseDir = __DIR__;

//
// сканирование
//
function renameDirFiles($dirPath) {
    global $names, $exts, $exclude;
    $files = scandir($dirPath);
    foreach ($files as $file) {
        if (in_array($file, $exclude)) {
            continue;
        }

        $filePath = $dirPath.'/'.$file;
        echo "process file: {$filePath}".PHP_EOL;

        if (is_dir($filePath)) {
            renameDirFiles($filePath);
        }
        else {
			$fileInfo = explode(".", $file);
            $fileExt = end($fileInfo);
            if (in_array($fileExt, $exts)) {
                $content = file_get_contents($filePath);
                $content = str_replace(
                    array_keys($names),
                    array_values($names),
                    $content
                );
                file_put_contents($filePath, $content);
            }
        }
    }
}
renameDirFiles($baseDir);
