<?php

class module_id extends CModule
{
    public $MODULE_NAME = "Название модуля";
	public $MODULE_VERSION = '1.0';
  	public $MODULE_VERSION_DATE = '2018-01-24';

    public function __construct()
    {
        $this->MODULE_ID = __CLASS__;
    }

    public function DoInstall()
    {
		$this->addSymlinkAdmin();
		$this->addSymlinkComponents();
        RegisterModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
		$this->removeSymlinkAdmin();
		$this->removeSymlinkComponents();
        UnRegisterModule($this->MODULE_ID);
    }

	public function addSymlinkAdmin()
	{
		$dir = __DIR__.'/../admin';
		if (!file_exists($dir)) {
			return;
		}

		$pages = scandir($dir);
		foreach ($pages as $page) {
			if (in_array($page, ['.', '..', 'menu.php'])) {
				continue;
			}
			symlink(
				$dir.'/'.$page,
				$this->getBitrixAdminPageName($page)
			);
		}
	}

	public function addSymlinkComponents()
	{
		$dir = __DIR__.'/../components';
		if (file_exists($dir)) {
			symlink($dir, $this->getBitrixComponentsDir());
		}
	}

	public function removeSymlinkAdmin()
	{
		$dir = __DIR__.'/../admin';
		if (!file_exists($dir)) {
			return;
		}

		$pages = scandir($dir);
		foreach ($pages as $page) {
			if (in_array($page, ['.', '..', 'menu.php'])) {
				continue;
			}
			unlink($this->getBitrixAdminPageName($page));
		}
	}

	public function removeSymlinkComponents()
	{
		$dir = $this->getBitrixComponentsDir();
		if (file_exists($dir)) {
			unlink($dir);
		}
	}

	protected function getBitrixComponentsDir()
	{
		return $_SERVER['DOCUMENT_ROOT'].'/local/components/';
	}

	protected function getBitrixAdminPageName(string $page)
	{
		return $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$this->MODULE_ID.'_'.$page;
	}
}
