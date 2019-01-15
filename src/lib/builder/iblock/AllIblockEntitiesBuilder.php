<?php

namespace bitrix_module\builder\iblock;

class AllIblockEntitiesBuilder
{
    protected $iblockTypeId;

    public function __construct(string $iblockTypeId)
    {
        $this->iblockTypeId = $iblockTypeId;
    }

    public function getCreateCode()
    {
        \CModule::includeModule('iblock');

        $phpCodes = [];
        $phpCodes[] = "<?php";
        $phpCodes[] = "\\CModule::includeModule('iblock');";
        $phpCodes[] = "\$GLOBALS['CACHE_MANAGER']->CleanAll();";

        $phpCodes[] = (new IblockTypeBuilder($this->iblockTypeId))->getCreateCode();
        $phpCodes[] = "?>\n";

        return join("\n\n", array_filter($phpCodes));
    }
}
