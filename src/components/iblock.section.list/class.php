<?php

namespace bitrix_module\components\classes;

class IblockSectionList extends \CBitrixComponent
{
	public function executeComponent()
	{
		$cacheTime = $this->arParams['CACHE_TIME'] ?? 3600;
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

		$iblockParams = $this->arParams['IBLOCK'];
		if (empty($iblockParams)) {
			throw new \Exception("Параметр 'IBLOCK' обязателен");
		}

		$cnt = $this->getCnt($iblockParams);
		$nav = $this->getNav($iblockParams);
		$order = $this->getOrder($iblockParams);
		$filter = $this->getFilter($iblockParams);
		$select = $this->getSelect($iblockParams);

		$this->arResult['IS_ONLY_ID'] = count($select) === 1 && $select[0] === 'ID';
		$this->arResult['RESULT'] = \CIBlockSection::getList($order, $filter, $cnt, $select, $nav);
		$this->includeComponentTemplate();
	}

	public function getOrder(array $iblockParams)
	{
		return $iblockParams['ORDER'] ?? ['SORT' => 'ASC'];
	}

	public function getFilter(array $iblockParams)
	{
		return $iblockParams['FILTER'] ?? [];
	}

	public function getCnt(array $iblockParams)
	{
		return (bool) ($iblockParams['ELEMENT_CNT'] ?? false);
	}

	public function getSelect(array $iblockParams)
	{
		return $iblockParams['SELECT'] ?? ['ID'];
	}

	public function getNav(array $iblockParams)
	{
		return $iblockParams['NAV'] ?? false;
	}
}
