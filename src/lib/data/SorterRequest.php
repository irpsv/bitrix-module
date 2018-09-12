<?php

namespace bitrix_module\data;

class SorterRequest
{
	public $sorter;
	public $queryName;
	public $queryValue;

	public function __construct(Sorter $sorter, $queryName = 's')
	{
		$this->sorter = $sorter;
		$this->queryName = (string) $queryName;
	}

	public function load(array $request)
	{
		$params = (array) ($request[$this->queryName] ?? []);
		foreach ($params as $field => $sort) {
			$this->sorter->setActive($field, $sort);
			return true;
		}
		return false;
	}
}
