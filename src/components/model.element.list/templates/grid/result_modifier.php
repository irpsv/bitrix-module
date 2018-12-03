<?php

$iblockDataSet = $arResult['DATA_SET'];
if (!$iblockDataSet) {
	return;
}

\CModule::includeModule('bitrix_module');

$iblockId = \bitrix_module\model\ExampleModel::getIblockId();
$arResult['HTML_ID'] = $this->GetEditAreaId($iblockId);
$arResult['BUTTONS'] = \CIBlock::GetPanelButtons($iblockId, null, null)['edit'] ?? null;
