<?php

class bitrix_module extends CModule
{
	private $PRODUCTION = false;

    public $MODULE_ID = "bitrix.module";
    public $MODULE_NAME = "bitrix_module_name";
	public $MODULE_VERSION = '1.0.0';
  	public $MODULE_VERSION_DATE = 'bitrix_module_date';

    public function __construct()
    {
        $this->PARTNER_NAME = "";
        $this->PARTNER_URI = "https://";
    }

    public function DoInstall()
    {
        $file = __DIR__.'/do-install.php';
        if (file_exists($file)) {
            include $file;
        }

		$this->addUrlRewriteRules();
        $this->copyInstallFiles();
		$this->copyAdminFiles();
		$this->copyComponentsFiles();

        RegisterModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        $file = __DIR__.'/do-uninstall.php';
        if (file_exists($file)) {
            include $file;
        }

		$this->removeAdminFiles();
		$this->removeComponentsFiles();

        UnRegisterModule($this->MODULE_ID);
    }

	public function copyAdminFiles()
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
            $filePath = $dir.'/'.$page;
			if ($this->PRODUCTION) {
				$rewrite = true;
				$recursive = true;
				$deleteAfterCopy = false;
				CopyDirFiles($filePath, $this->getBitrixAdminPageName($page), $rewrite, $recursive, $deleteAfterCopy);
			}
			else {
				symlink($filePath, $this->getBitrixAdminPageName($page));
			}
		}
	}

	public function copyComponentsFiles()
	{
		$dir = __DIR__.'/../components';
		if (file_exists($dir)) {
			if ($this->PRODUCTION) {
				$rewrite = true;
				$recursive = true;
				$deleteAfterCopy = false;
				CopyDirFiles($dir, $this->getBitrixComponentsDir(), $rewrite, $recursive, $deleteAfterCopy);
			}
			else {
				symlink($dir, $this->getBitrixComponentsDir());
			}
		}
	}

    public function addUrlRewriteRules()
    {
        if (file_exists(__DIR__.'/urlrewrite.php')) {
            $rules = include __DIR__.'/urlrewrite.php';
            if (is_array($rules)) {
                foreach ($rules as $rule) {
                    \CUrlRewriter::add($rule);
                }
            }
        }
    }

    public function copyInstallFiles()
    {
        $dir = __DIR__.'/public';
        if (file_exists($dir) && is_dir($dir)) {
            $rewrite = true;
            $recursive = true;
            $deleteAfterCopy = false;
            $files = scandir($dir);
            foreach ($files as $file) {
                if (in_array($file, ['.', '..'])) {
                    continue;
                }

                $sourcePath = $dir.'/'.$file;
                $targetPath = $_SERVER['DOCUMENT_ROOT'].'/'.$file;

                CopyDirFiles($sourcePath, $targetPath, $rewrite, $recursive, $deleteAfterCopy);
            }
        }
    }

	public function removeAdminFiles()
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

	public static function unlinkRecursive(string $path)
	{
		if (!file_exists($path)) {
			return;
		}
		else if (is_dir($path)) {
			$childs = scandir($path);
			$exclude = ['.', '..'];
			foreach ($childs as $child) {
				if (in_array($child, $exclude)) {
					continue;
				}
				$childPath = $path.'/'.$child;
				self::unlinkRecursive($childPath);
			}
			rmdir($path);
		}
		else {
			unlink($path);
		}
	}

	public function removeComponentsFiles()
	{
		$dir = $this->getBitrixComponentsDir();
		if (file_exists($dir)) {
			if ($this->PRODUCTION) {
				self::unlinkRecursive($dir);
			}
			else {
				unlink($dir);
			}
		}
	}

	protected function getBitrixComponentsDir()
	{
		return $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$this->MODULE_ID;
	}

	protected function getBitrixAdminPageName(string $page)
	{
		return $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$this->MODULE_ID.'_'.$page;
	}
}
