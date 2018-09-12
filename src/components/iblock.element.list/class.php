<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\PagerRequestBuildByComponentParams;
use bitrix_module\data\FilterRequestBuildByComponentParams;
use bitrix_module\data\SorterRequestBuildByComponentParams;

class IblockElementList extends \CBitrixComponent
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
		\CModule::includeModule('bitrix_module');

		$iblockParams = $this->arParams['IBLOCK'];
		if (empty($iblockParams)) {
			throw new \Exception("Параметр 'IBLOCK' обязателен");
		}

		$nav = $this->getNav($iblockParams);
		$order = $this->getOrder($iblockParams);
		$group = $this->getGroup($iblockParams);
		$filter = $this->getFilter($iblockParams);
		$select = $this->getSelect($iblockParams);

		$filterRequest = $this->getFilterRequest();
		if ($filterRequest) {
			$filterRequest->load($_GET);
			$filter = array_merge(
				$filterRequest->filter->getActive(),
				$filter
			);
		}

		$sorterRequest = $this->getSorterRequest();
		if ($sorterRequest) {
			$sorterRequest->load($_GET);
			$order = array_merge(
				$sorterRequest->sorter->getActive(),
				$order
			);
		}

		$totalCount = $this->getTotalCount($filter, $group);
		$pagerRequest = $this->getPagerRequest($totalCount);
		if ($pagerRequest) {
			$pagerRequest->load($_GET);
			$nav = [
				'iNumPage' => $pagerRequest->pager->getPageNow(),
				'nPageSize' => $pagerRequest->pager->getPageSize(),
			];
		}

		$this->arResult['IS_ONLY_ID'] = count($select) === 1 && $select[0] === 'ID';
		$this->arResult['PAGER_REQUEST'] = $pagerRequest;
		$this->arResult['SORTER_REQUEST'] = $sorterRequest;
		$this->arResult['FILTER_REQUEST'] = $filterRequest;
		$this->arResult['RESULT'] = \CIBlockElement::getList($order, $filter, $group, $nav, $select);
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

	public function getGroup(array $iblockParams)
	{
		return $iblockParams['GROUP'] ?? false;
	}

	public function getSelect(array $iblockParams)
	{
		return $iblockParams['SELECT'] ?? ['ID'];
	}

	public function getNav(array $iblockParams)
	{
		return $iblockParams['NAV'] ?? false;
	}

	public function getFilterRequest()
	{
		$params = $this->arParams['FILTER_PARAMS'] ?? null;
		if (!$params) {
			return null;
		}
		return FilterRequestBuildByComponentParams::runStatic($params);
	}

	public function getSorterRequest()
	{
		$params = $this->arParams['SORTER_PARAMS'] ?? null;
		if (!$params) {
			return null;
		}
		return SorterRequestBuildByComponentParams::runStatic($params);
	}

	public function getTotalCount($filter, $group)
	{
		return (int) \CIBlockElement::getList([], $filter, $group)->selectedRowsCount();
	}

	public function getPagerRequest($totalCount)
	{
		$params = $this->arParams['PAGER_PARAMS'] ?? null;
		if (!$params) {
			return null;
		}
		if (!isset($params['PAGER_REQUEST'])) {
			$params['TOTAL_COUNT'] = $totalCount;
		}
		return PagerRequestBuildByComponentParams::runStatic($params);
	}
}
