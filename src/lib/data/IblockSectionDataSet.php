<?php

namespace bitrix_module\data;

class IblockSectionDataSet extends DataSet
{
	protected $select;
	protected $defaultOrder;
	protected $defaultFilter;

	protected function init()
	{
		\CModule::includeModule('iblock');
	}

	public function setDefaultOrder($order)
	{
		$this->defaultOrder = $order;
	}

	public function setDefaultFilter($filter)
	{
		$this->defaultFilter = $filter;
	}

	public function setSelect(array $select)
	{
		$this->select = $select;
	}

	public function getFilterValue()
	{
		$filter = $this->defaultFilter ?: [];
		if ($this->filter) {
			$filter = array_merge(
				$filter,
				$this->filter->getActive()
			);
		}
		return $filter;
	}

	public function getOrderValue()
	{
		$order = $this->defaultOrder ?: [];
		if ($this->sorter) {
			$order = array_merge(
				$order,
				$this->sorter->getActive()
			);
		}
		return $order;
	}

	public function getTotalCount()
	{
		$filter = $this->getFilterValue();
		return (int) \CIBlockSection::getList([], $filter, []);
	}

	public function getItems()
	{
		$filter = $this->getFilterValue();
		$order = $this->getOrderValue();
		$nav = false;
		if ($this->pager) {
			$nav = [
				'iNumPage' => $this->pager->getPageNow(),
				'nPageSize' => $this->pager->getPageSize(),
			];
		}

		$rows = [];
		$result = \CIBlockSection::getList($order, $filter, false, $this->select, $nav);
		while ($row = $result->fetch()) {
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function getIblockId()
	{
		$activeFilter = $this->filter ? $this->filter->getActive() : [];
		if (isset($activeFilter['IBLOCK_ID'])) {
			return $activeFilter['IBLOCK_ID'];
		}

		$defaultFilter = $this->defaultFilter ?: [];
		if (isset($defaultFilter['IBLOCK_ID'])) {
			return $defaultFilter['IBLOCK_ID'];
		}

		$row = \CIBlockSection::getList([], $defaultFilter, false, ['IBLOCK_ID'])->fetch();
		return $row ? $row['IBLOCK_ID'] : null;
	}
}
