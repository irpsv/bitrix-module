<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\Sorter;
use bitrix_module\data\SorterRequest;
use bitrix_module\data\SorterRequestBuildByComponentParams;

class SorterView extends \CBitrixComponent
{
	public function executeComponent()
	{
		\CModule::includeModule('bitrix_module');

		$sorterRequest = SorterRequestBuildByComponentParams::runStatic($this->arParams);
		$sorterRequest->load($_GET);
		$sorter = $sorterRequest->sorter;

		$this->arResult['LABELS'] = $sorter->getLabels();
		$this->arResult['FIELDS'] = $sorter->getFields();
		$this->arResult['ACTIVE'] = $sorter->getActive();
		$this->arResult['REQUEST_NAME'] = $sorterRequest->queryName;
		$this->includeComponentTemplate();

		return $sorterRequest;
	}
}
