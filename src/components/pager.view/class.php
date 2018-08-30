<?php

namespace module_id\components\classes;

/**
 * Параметры:
 * PAGE_NOW - текущая страница
 * PAGE_SIZE - размер страницы
 * TOTAL_COUNT - количество всех записей
 * REQUEST_NAME - имя запроса
 */
class PagerView extends \CBitrixComponent
{
	public function executeComponent()
	{
		$this->run();
	}

	public function run()
	{
		$pageNow = (int) ($this->arParams['PAGE_NOW'] ?? 1);
		$pageSize = (int) ($this->arParams['PAGE_SIZE'] ?? 0);
		$totalCount = (int) ($this->arParams['TOTAL_COUNT'] ?? 0);
		$requestName = (string) ($this->arParams['REQUEST_NAME'] ?? 'p');

		if (!$pageSize) {
			throw new \Exception("Параметр 'PAGE_SIZE' обязателен");
		}

		$this->arResult['PAGE_NOW'] = $pageNow;
		$this->arResult['PAGE_SIZE'] = $pageSize;
		$this->arResult['PAGE_MAX'] = ceil($totalCount / $pageSize);
		$this->arResult['REQUEST_NAME'] = $requestName;
		$this->includeComponentTemplate();
	}
}
