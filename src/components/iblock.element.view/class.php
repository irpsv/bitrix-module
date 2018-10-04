<?php

namespace bitrix_module\components\classes;

class IblockElementView extends \CBitrixComponent
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

		$id = $this->arParams['ID'] ?? null;
		$row = $this->arParams['ROW'] ?? null;
		$filter = $this->arParams['FILTER'] ?? null;

		if ($row) {
			if (!is_array($row)) {
				throw new \Exception("Параметр 'ROW' должен быть массивом");
			}
		}
		else if ($id) {
			$row = $this->getRowByFilter([
				'ID' => $id,
			]);
		}
		else if ($filter) {
			$row = $this->getRowByFilter($filter);
		}
		else {
			throw new \Exception("Должен быть заполнен один из параметров: 'ID', 'ROW', 'FILTER'");
		}

		if (!$row && $this->arParams['PROCESS_404']) {
			include $_SERVER['DOCUMENT_ROOT'].'/404.php';
			die();
		}

		$this->arResult['ROW'] = $row;
		$this->includeComponentTemplate();
	}

	public function getRowByFilter(array $filter)
	{
		return \CIBlockElement::getList([], $filter)->fetch();
	}
}
