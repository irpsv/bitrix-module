<?php

//
// autoload
//

include_once __DIR__.'/autoload.php';

$loader = new Psr4AutoloaderClass();
$loader->addNamespace('module_id', __DIR__.'/lib');
$loader->addNamespace('module_id\components', __DIR__.'/components');
$loader->register();

//
// events
//
//
// AddEventHandler('iblock', 'OnIBlockPropertyBuildList', function(){
//
// });
