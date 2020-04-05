<?php

class rpsv_main extends CModule
{
    public $MODULE_ID = "rpsv.main";
    public $MODULE_NAME = "Rpsv Main";
	public $MODULE_VERSION = '1.0.0';
  	public $MODULE_VERSION_DATE = 'Rpsv Main';

    public function DoInstall()
    {
        $file = __DIR__.'/do-install.php';
        if (file_exists($file)) {
            include $file;
        }
        RegisterModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        $file = __DIR__.'/do-uninstall.php';
        if (file_exists($file)) {
            include $file;
        }
        UnRegisterModule($this->MODULE_ID);
    }
}
