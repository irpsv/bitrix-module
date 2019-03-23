<?php

$iblockDataSet = $arResult['DATA_SET'];
if (!$iblockDataSet) {
	return;
}

$iblockId = $iblockDataSet->getIblockId();
$arResult['HTML_ID'] = $this->GetEditAreaId($iblockId);
$arResult['BUTTONS'] = \CIBlock::GetPanelButtons($iblockId, null, null)['edit'] ?? null;
