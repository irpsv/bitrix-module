<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\FilterRequestBuildByComponentParams;

class FilterView extends \CBitrixComponent
{
	public function executeComponent()
	{
		\CModule::includeModule('bitrix.module');

		$method = isset($this->arParams['METHOD']) && strtolower($this->arParams['METHOD']) === 'post'
			? 'post'
			: 'get';
		$data = $method === 'get' ? $_GET : $_POST;

		$filterRequest = FilterRequestBuildByComponentParams::runStatic($this->arParams);
		$filterRequest->load($data);
		$filter = $filterRequest->filter;

		$this->arResult['METHOD'] = $method;
		$this->arResult['FILTER'] = $filter;
		$this->arResult['FIELDS'] = $filter->getFields();
		$this->arResult['REQUEST_NAME'] = $filterRequest->queryName;
		$this->includeComponentTemplate();

		return $filterRequest;
	}
}
