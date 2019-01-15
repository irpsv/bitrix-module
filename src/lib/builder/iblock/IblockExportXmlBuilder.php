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

    public function getCreateCode()
    {
        $row = \CIBlock::getList([], [
            'CODE' => $this->iblockCode,
            'CHECK_PERMISSIONS' => 'N',
        ])->fetch();
        $iblockTypeId = $row['IBLOCK_TYPE_ID'];

        return trim("
<?php

\\CModule::includeModule('iblock');

\$NS = \$sectionsMap = \$pricesMap = null;
\$workDir = __DIR__.'/iblock/';
\$filePath = \"{\$workDir}/{$this->saveFile}\";
\$iblockTypeId  = '{$iblockTypeId}';
\$siteId = \Bitrix\Main\SiteTable::getRow([
    'filter' => [
        '=DEF' => 'Y',
    ],
])['LID'];

\$obXMLFile = new \CIBlockXMLFile;
\$obXMLFile->DropTemporaryTables();
\$obXMLFile->CreateTemporaryTables();

\$file = fopen(\$filePath, 'rb');
\$obXMLFile->ReadXMLToDatabase(\$file, \$NS, 0);
\CIBlockXMLFile::IndexTemporaryTables();

\$obCatalog = new \CIBlockCMLImport;
\$obCatalog->InitEx(\$NS, [
    'files_dir' => \$workDir
]);
\$obCatalog->ImportMetaData([1,2], \$iblockTypeId, \$siteId);
\$obCatalog->ImportSections();
\$obCatalog->SectionsResort();
\$obCatalog->ReadCatalogData(\$sectionsMap, \$pricesMap);
\$obCatalog->ImportElements(time(), 0);
\$obCatalog->ImportProductSets();

?>
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
