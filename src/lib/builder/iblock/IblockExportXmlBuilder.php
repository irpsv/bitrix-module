<?php

namespace bitrix_module\builder\iblock;

use bitrix_module\builder\general\BaseMapperBuilder;

class IblockExportXmlBuilder extends BaseMapperBuilder
{
    protected $saveDir;
    protected $saveFile;
    protected $iblockCode;

    public function __construct($iblockCode, $saveDir, $saveFile)
    {
        \CModule::includeModule('iblock');

        $this->saveDir = str_replace('//', '/', $saveDir);
        $this->saveFile = trim($saveFile, '/');
        $this->iblockCode = $iblockCode;
    }

    public function getIblockId()
    {
        $row = \CIBlock::getList([], [
            'CODE' => $this->iblockCode,
            'CHECK_PERMISSIONS' => 'N',
        ])->fetch();
        return $row ? $row['ID'] : null;
    }

	public function getUserOptionsCode(array $iblock)
	{
		$value = \CUserOptions::getOption('form', 'form_element_'.$iblock['ID'], false, 0);
		if (!$value) {
			return "";
		}

		$valueStr = serialize($value);
		return trim("
<?php

\$iblock = \CIBlock::getList([], [
	'TYPE' => '{$iblock['IBLOCK_TYPE_ID']}',
	'CODE' => '{$iblock['CODE']}',
])->fetch();
if (\$iblock) {
	\$value = unserialize('{$valueStr}');
	\CUserOptions::setOption('form', 'form_element_'.\$iblock['ID'], \$value, true);
}

?>
		");
	}

    public function getCreateCode()
    {
        $row = \CIBlock::getList([], [
            'CODE' => $this->iblockCode,
            'CHECK_PERMISSIONS' => 'N',
        ])->fetch();
        $iblockTypeId = $row['IBLOCK_TYPE_ID'];

		$userOptionsCode = $this->getUserOptionsCode($row);

        return trim("
<?php

\CModule::includeModule('iblock');

\$GLOBALS['CACHE_MANAGER']->CleanAll();

\$workDir = __DIR__.'/iblock/';
\$filePath = \"{\$workDir}/{$this->saveFile}\";
\$siteId = \\Bitrix\\Main\\SiteTable::getRow([
    'filter' => [
        '=DEF' => 'Y',
    ],
])['LID'];

\$NS = [
	'STEP' => 0,
	'IBLOCK_TYPE' => '{$iblockTypeId}',
	'LID' => [
		\$siteId
	],
	'ACTION' => 'N',
	'PREVIEW' => true,
];
\$obXMLFile = new \\CIBlockXMLFile;

\\CIBlockXMLFile::DropTemporaryTables();
\\CIBlockXMLFile::CreateTemporaryTables();

\$file = fopen(\$filePath, 'rb');
\$obXMLFile->ReadXMLToDatabase(\$file, \$NS, 0);
fclose(\$file);

\CIBlockXMLFile::IndexTemporaryTables();

\$obCatalog = new \\CIBlockCMLImport;
\$obCatalog->Init(\$NS, \$workDir, true, \$NS['PREVIEW'], false, true);
\$obCatalog->ImportMetaData(array(1, 2), \$NS['IBLOCK_TYPE'], \$NS['LID']);

\$obCatalog->Init(\$NS, \$workDir, true, \$NS['PREVIEW'], false, true);
\$obCatalog->ImportSections();

\$obCatalog->Init(\$NS, \$workDir, true, \$NS['PREVIEW'], false, true);
\$obCatalog->DeactivateSections('A');

\$startTime = time();
\$pricesMap = false;
\$sectionsMap = false;

\$obCatalog->Init(\$NS, \$workDir, true, \$NS['PREVIEW'], false, true);
\$obCatalog->ReadCatalogData(\$sectionsMap, \$pricesMap);

\$obCatalog->Init(\$NS, \$workDir, true, \$NS['PREVIEW'], false, true);
\$obCatalog->ImportElements(\$startTime, 0);

\$obCatalog->Init(\$NS, \$workDir, true, \$NS['PREVIEW'], false, true);
\$obCatalog->DeactivateElement(\$NS['ACTION'], \$startTime, 0);

\$obCatalog->Init(\$NS, \$workDir, true, \$NS['PREVIEW'], false, true);
\$obCatalog->ImportProductSets();

unset(\$obXMLFile, \$obCatalog);

?>
{$userOptionsCode}
        ");
    }

    public function build()
    {
        if (!file_exists($this->saveDir)) {
            mkdir($this->saveDir, 0755);
        }

        $file = fopen($this->saveDir.$this->saveFile, 'ab');
        if (!$file) {
            throw new \Exception("Файл не создан");
        }

        $export = new \CIBlockCMLExport;
        $ret = $export->Init($file, $this->getIblockId(), [], true, $this->saveDir, false, false);
        if (!$ret) {
            throw new \Exception("Не удалось инициализировать экспорт");
        }

        $sections = [];
        $properties = [];

        // $export->DoNotDownloadCloudFiles();
        $export->StartExport();

		$export->StartExportMetadata();
		$export->ExportProperties($properties);
        $export->ExportSections($sections, time(), 0, "all", $properties);
        $export->EndExportMetadata();

		$export->StartExportCatalog();
        $export->ExportElements($properties, $sections, time(), 0, 0, "all");
        $export->EndExportCatalog();

		$export->ExportProductSets();
		$export->EndExport();

        fclose($file);
    }
}
