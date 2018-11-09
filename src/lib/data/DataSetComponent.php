<?php

namespace bitrix_module\data;

use bitrix_module\data\IblockElementDataSet;
use bitrix_module\data\PagerRequestBuildByComponentParams;
use bitrix_module\data\FilterRequestBuildByComponentParams;
use bitrix_module\data\SorterRequestBuildByComponentParams;

trait DataSetComponent
{
	abstract public function getDataSet();

	public function run()
	{
		\CModule::includeModule('iblock');

		$dataSet = $this->getDataSet();
		$filterRequest = $this->getFilterRequest();
		if ($filterRequest) {
			$filterRequest->load($_GET);
			$dataSet->setFilter($filterRequest->filter);
		}

		$sorterRequest = $this->getSorterRequest();
		if ($sorterRequest) {
			$sorterRequest->load($_GET);
			$dataSet->setSorter($sorterRequest->sorter);
		}

		$pagerRequest = $this->getPagerRequest(
			$dataSet->getTotalCount()
		);
		if ($pagerRequest) {
			$pagerRequest->load($_GET);
			$dataSet->setPager($pagerRequest->pager);
		}

		$this->arResult['DATA_SET'] = $dataSet;
		$this->arResult['PAGER_REQUEST'] = $pagerRequest;
		$this->arResult['SORTER_REQUEST'] = $sorterRequest;
		$this->arResult['FILTER_REQUEST'] = $filterRequest;
		$this->includeComponentTemplate();
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
