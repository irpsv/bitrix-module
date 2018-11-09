<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\DataSetComponent;
use bitrix_module\data\IblockElementDataSet;

\CModule::includeModule('bitrix_module');

class ModelElementList extends \CBitrixComponent
{
	use DataSetComponent;

	public function executeComponent()
	{
		$cacheTime = $this->arParams['CACHE_TIME'] ?? 36000000;
		$cacheAdditionalId = null;
		$cachePath = preg_replace('/[^a-z0-9]/i', '_', __CLASS__);
		if ($this->startResultCache($cacheTime, $cacheAdditionalId, $cachePath)) {
			$this->run();
			$this->endResultCache();
		}
	}

	public function getIblockParams()
	{
		return [
			'SELECT' => [
				'ID',
			],
			'FILTER' => [
				'ACTIVE' => 'Y',
				'IBLOCK_CODE' => 'value',
				'CHECK_PERMISSIONS' => 'N',
			],
			'ORDER' => [
				'SORT' => 'ASC',
			],
		];
	}

	public function getDataSet()
	{
		$iblockParams = $this->getIblockParams();
		$filter = $iblockParams['FILTER'] ?? [];
		$select = $iblockParams['SELECT'] ?? ['ID'];
		$order = $iblockParams['ORDER'] ?? ['SORT' => 'ASC'];
		if (empty($filter)) {
			throw new \Exception("Фильтр инфоблока должен быть указан");
		}

		$dataSet = new IblockElementDataSet();
		$dataSet->setDefaultOrder($order);
		$dataSet->setDefaultFilter($filter);
		$dataSet->setSelect($select);
		return $dataSet;
	}
}
