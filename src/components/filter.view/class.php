<?php

namespace module_id\components\classes;

/**
 * Параметры:
 * NAMES - имена атрибутов
 * VALUES - значения атрибутов
 * ACTIVE - активные атрибуты
 */
class FilterView extends \CBitrixComponent
{
	public function executeComponent()
	{
		$this->run();
	}

	public function run()
	{
		$names = (array) ($this->arParams['NAMES'] ?? []);
		if (empty($names)) {
			throw new \Exception("Параметр 'NAMES' обязательный");
		}

		$values = (array) ($this->arParams['VALUES'] ?? []);
		$active = (array) ($this->arParams['ACTIVE'] ?? []);
		$requestName = (string) ($this->arParams['REQUEST_NAME'] ?? 'f');

		$this->arResult['NAMES'] = $names;
		$this->arResult['VALUES'] = $values;
		$this->arResult['ACTIVE'] = $active;
		$this->arResult['REQUEST_NAME'] = $requestName;
		$this->includeComponentTemplate();
	}
}
