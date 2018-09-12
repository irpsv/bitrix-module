<?php

//
// autoload
//

include_once __DIR__.'/autoload.php';

$loader = new Psr4AutoloaderClass();
$loader->addNamespace('bitrix_module', __DIR__.'/lib');
$loader->register();

//
// events
//
//
// AddEventHandler('iblock', 'OnIBlockPropertyBuildList', function(){
//
// });
