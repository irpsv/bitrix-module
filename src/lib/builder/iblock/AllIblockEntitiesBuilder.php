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
        $phpCodes = [];
        $phpCodes[] = "<?php";
        $phpCodes[] = "\\CModule::includeModule('iblock');";
        $phpCodes[] = "\$GLOBALS['CACHE_MANAGER']->CleanAll();";
        $phpCodes[] = (new IblockTypeBuilder($this->iblockTypeId))->getCreateCode();
        $phpCodes[] = "?>\n";

        return join("\n\n", array_filter($phpCodes));
    }

    public function getDeleteCode()
    {
        $phpCodes = [];
        $phpCodes[] = "<?php";
        $phpCodes[] = "\\CModule::includeModule('iblock');";
        $phpCodes[] = (new IblockTypeBuilder($this->iblockTypeId))->getDeleteCode();
        $phpCodes[] = "\$GLOBALS['CACHE_MANAGER']->CleanAll();";
        $phpCodes[] = "?>\n";

        return join("\n\n", array_filter($phpCodes));
    }
}
