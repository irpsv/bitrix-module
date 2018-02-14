<?php

//
// autoload
//

include_once __DIR__.'/autoload.php';

$loader = new Psr4AutoloaderClass();
$loader->addNamespace('module_id', __DIR__.'/lib');
$loader->register();

//
// events
//
//
// AddEventHandler('iblock', 'OnIBlockPropertyBuildList', function(){
//
// });
