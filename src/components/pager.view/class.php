<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\PagerRequest;
use bitrix_module\data\PagerRequestBuildByComponentParams;

/**
 * Параметры:
 * PAGER_REQUEST - объект PagerRequest (если он указан, то остальные можно не указывать)
 * PAGE_NOW - текущая страница
 * PAGE_SIZE - размер страницы
 * TOTAL_COUNT - количество всех записей
 * REQUEST_NAME - имя запроса
 */
class PagerView extends \CBitrixComponent
{
	public function executeComponent()
	{
		\CModule::includeModule('bitrix_module');

		$pagerRequest = PagerRequestBuildByComponentParams::runStatic($this->arParams);
		$pagerRequest->load($_GET);
		$pager = $pagerRequest->pager;

		$this->arResult['PAGE_NOW'] = $pager->getPageNow();
		$this->arResult['PAGE_SIZE'] = $pager->getPageSize();
		$this->arResult['PAGE_MAX'] = $pager->getPageMax();
		$this->arResult['REQUEST_NAME'] = $pagerRequest->queryName;
		$this->includeComponentTemplate();

		return $pagerRequest;
	}
}
