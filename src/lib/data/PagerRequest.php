<?php

namespace bitrix_module\data;

class PagerRequest
{
	public $pager;
	public $queryName;
	public $queryValue;
	public $isOnlyData = false;

	public function __construct(Pager $pager, $queryName = 'p')
	{
		$this->pager = $pager;
		$this->queryName = (string) $queryName;
	}

	public function load(array $request)
	{
		if ($this->isOnlyData) {
			return null;
		}

		$pageNow = (int) ($request[$this->queryName] ?? 0);
		if ($pageNow) {
			$this->queryValue = $pageNow;
			$this->pager->setPageNow($pageNow);
			return true;
		}
		return false;
	}
}
