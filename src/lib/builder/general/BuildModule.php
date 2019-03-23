<?php

namespace bitrix_module\builder\general;

class BuildModule
{
	public $savedDir;
	public $saveFiles;
	public $iblockTypes;
	public $iblockCodes;

	public function __construct()
    {

    }

	public function validateParams()
	{
		if (!file_exists($this->savedDir)) {
            throw new \Exception("Указанная директория для билдинга не найдена");
        }
	}

    public function build()
    {
		$this->validateParams();

        \CModule::includeModule('iblock');

		if ($this->saveFiles) {
			$savedFilesDir = rtrim($this->savedDir, '/').'/public';
	        if (!file_exists($savedFilesDir)) {
	            mkdir($savedFilesDir, 0755);
	        }

			$rewrite = true;
			$recursive = true;
			foreach ($this->saveFiles as $fileName) {
				$to = rtrim($savedFilesDir, '/').'/'.ltrim($fileName, '/');
				$from = rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/'.ltrim($fileName, '/');
				CopyDirFiles($from, $to, $rewrite, $recursive);
			}
		}

		$installPhpCodes = [];
		$unInstallPhpCodes = [];
		$iblockFilesDir = $this->savedDir.'/iblock/';
        foreach ($this->iblockTypes as $iblockTypeId) {
            $buildIblock = new \bitrix_module\builder\iblock\AllIblockEntitiesBuilder($iblockTypeId);
            $installPhpCodes[] = $buildIblock->getCreateCode();
			$unInstallPhpCodes[] = $buildIblock->getDeleteCode();

			$iblockCodes = $this->getIblockCodes($iblockTypeId);
			foreach ($iblockCodes as $iblockCode) {
                $xmlFileName = "{$iblockCode}.xml";
                $buildFiles = new \bitrix_module\builder\iblock\IblockExportXmlBuilder($iblockCode, $iblockFilesDir, $xmlFileName);
				$buildFiles->build();
                $installPhpCodes[] = $buildFiles->getCreateCode();
            }
        }

		$savedInstallFile = rtrim($this->savedDir, '/').'/do-install.php';
        $installPhpCodesStr = join("\n\n", $installPhpCodes);
        file_put_contents($savedInstallFile, $installPhpCodesStr);

		$savedUnInstallFile = rtrim($this->savedDir, '/').'/do-uninstall.php';
        $unInstallPhpCodesStr = join("\n\n", $unInstallPhpCodes);
        file_put_contents($savedUnInstallFile, $unInstallPhpCodesStr);

        return true;
    }

    public function getIblockCodes($iblockTypeId)
    {
        $filter = [
            'IBLOCK_TYPE_ID' => $iblockTypeId,
        ];
        if ($this->iblockCodes) {
            $filter['@CODE'] = $this->iblockCodes;
        }
        $rows = \Bitrix\Iblock\IblockTable::getList([
            'select' => ['CODE'],
            'filter' => $filter,
        ])->fetchAll();
        return array_column($rows, 'CODE');
    }
}
