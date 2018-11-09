<?php

namespace bitrix_module\data;

trait ItemViewComponent
{
    abstract public function getRowByFilter(array $filter);

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
}
