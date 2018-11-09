<?php

namespace bitrix_module\data;

class FilterRequest
{
	public $filter;
	public $queryName;

	public function __construct(Filter $filter, string $queryName = 'f')
	{
		$this->filter = $filter;
		$this->queryName = $queryName;
	}

	public function load(array $request)
	{
		// если queryName пустое, то загрузка не производится
		if (!$this->queryName) {
			return null;
		}
		
		$isLoad = false;
		$requestValues = $request[$this->queryName] ?? [];
		if ($requestValues) {
			$names = $this->filter->getFieldsNames();
			foreach ($names as $name) {
				if (!array_key_exists($name, $requestValues)) {
					continue;
				}

				$isLoad = true;
				$this->filter->setValue($name, $requestValues[$name]);
			}
		}
		return $isLoad;
	}
}
