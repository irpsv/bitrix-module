<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\ItemViewComponent;

\CModule::includeModule('bitrix_module');

class ModelElementView extends \CBitrixComponent
{
	use ItemViewComponent;
	
	public function getIblockParams()
	{
		return [
			'SELECT' => [
				'ID',
			],
			'FILTER' => [
				'ACTIVE' => 'Y',
				'IBLOCK_CODE' => '',
				'CHECK_PERMISSIONS' => 'N',
			],
		];
	}

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

	public function getRowByFilter(array $filter)
	{
		$iblockParams = $this->getIblockParams();
		$select = $iblockParams['SELECT'] ?? ['ID'];
		$filter = array_merge(
			$iblockParams['FILTER'] ?? [],
			$filter
		);
		return \CIBlockElement::getList([], $filter, false, false, $select)->fetch();
	}
}
