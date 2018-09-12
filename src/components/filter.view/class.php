<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\Filter;
use bitrix_module\data\FilterRequest;
use bitrix_module\data\FilterRequestBuildByComponentParams;

/**
 * Параметры:
 * NAMES - имена атрибутов
 * VALUES - значения атрибутов
 * ACTIVE - активные атрибуты
 * LABELS - лэйблы атрибутов
 * TYPES - тип атрибутов
 */
class FilterView extends \CBitrixComponent
{
	public function executeComponent()
	{
		\CModule::includeModule('bitrix_module');

		$filterRequest = FilterRequestBuildByComponentParams::runStatic($this->arParams);
		$filterRequest->load($_GET);
		$filter = $filterRequest->filter;

		$this->arResult['FILTER'] = $filter;
		$this->arResult['FIELDS'] = $filter->getFields();
		$this->arResult['REQUEST_NAME'] = $filterRequest->queryName;
		$this->includeComponentTemplate();

		return $filterRequest;
	}
}
