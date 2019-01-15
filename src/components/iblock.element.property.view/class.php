<?php

namespace bitrix_module\components\classes;

class IblockElementPropertyView extends \CBitrixComponent
{
	public function executeComponent()
	{
		$cacheTime = $this->arParams['CACHE_TIME'] ?? 86400000;
		$cacheAdditionalId = null;
		$cachePath = preg_replace('/[^a-z0-9]/i', '_', __CLASS__);
		if ($this->startResultCache($cacheTime, $cacheAdditionalId, $cachePath)) {
			$this->run();
			$this->endResultCache();
		}
	}

    public function run()
    {
        \CModule::includeModule('iblock');

        $value = $this->arParams['VALUE'] ?? null;
        if ($value === null) {
            $value = $this->getValueByParams();
        }

        $this->arResult['VALUE'] = $value;
        $this->includeComponentTemplate();
    }

    public function getValueByParams()
    {
        $elementId = $this->arParams['ELEMENT_ID'] ?? null;
		if (!$elementId) {
			throw new \Exception("Параметр 'ELEMENT_ID' или 'VALUE' должен быть указан");
		}

        $iblockId = $this->arParams['IBLOCK_ID'] ?? null;
		if (!$iblockId) {
			$iblockId = $this->getIblockIdByElementId($elementId);
		}
        $order = $this->arParams['ORDER'] ?? ['ID' => 'ASC'];
        $filter = $this->arParams['FILTER'] ?? [];

        $values = [];
        $result = \CIBlockElement::getProperty($iblockId, $elementId, $order, $filter);
        while ($row = $result->fetch()) {
            $values[] = $row;
        }
        return $values;
    }

	public function getIblockIdByElementId($elementId)
	{
		$row = \CIBlockElement::getById($elementId)->fetch();
		if (!$row) {
			throw new \Exception("Элемент '{$elementId}' не найден");
		}
		return $row['IBLOCK_ID'];
	}
}
