<?php

namespace bitrix_module\data;

abstract class DataSet
{
	protected $pager;
	protected $sorter;
	protected $filter;

	abstract public function getTotalCount();

	abstract public function getItems();

	public function __construct()
	{
		$this->init();
	}

	protected function init()
	{
		// pass
	}

	public function setFilter(Filter $filter)
	{
		$this->filter = $filter;
	}

	public function getFilter()
	{
		return $this->filter;
	}

	public function setPager(Pager $pager)
	{
		$this->pager = $pager;
	}

	public function getPager()
	{
		return $this->pager;
	}

	public function setSorter(Sorter $sorter)
	{
		$this->sorter = $sorter;
	}

	public function getSorter()
	{
		return $this->sorter;
	}
}
