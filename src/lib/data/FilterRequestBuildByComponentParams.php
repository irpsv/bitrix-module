<?php

namespace bitrix_module\data;

class FilterRequestBuildByComponentParams
{
	protected $arParams;

	public static function runStatic(array $arParams)
	{
		$self = new self($arParams);
		return $self->run();
	}

	public function __construct(array $arParams)
	{
		$this->arParams = $arParams;
	}

	public function run()
	{
		$filterRequest = $this->arParams['FILTER_REQUEST'] ?? null;
		if ($filterRequest instanceof FilterRequest) {
			return $filterRequest;
		}
		else if ($filterRequest) {
			throw new \Exception("Параметр 'FILTER_REQUEST' должен реализовывать класс ". FilterRequest::class);
		}
		else {
			// pass
		}

		$iblock = $this->arParams['IBLOCK'];
		$active = (array) ($this->arParams['ACTIVE'] ?? []);

		if ($iblock) {
			$filterRequest = FilterRequestBuildByIblockParams::runStatic(
				$iblock['ID'],
				$iblock['FIELDS']
			);
		}
		else {
			$fields = $this->arParams['FIELDS'];
			if (!$fields) {
				if ($active) {
					$fields = array_keys($active);
				}
				else {
					throw new \Exception("Параметр 'FIELDS' обязателен");
				}
			}

			$filter = new Filter();
			foreach ($fields as $field) {
				$filter->addField($field);
			}

			$filterRequest = new FilterRequest($filter);
		}

		foreach ($active as $name => $value) {
			$filterRequest->filter->setValue($name, $value);
		}

		$filterRequest->queryName = (string) ($this->arParams['REQUEST_NAME'] ?? 'f');
		$filterRequest->isOnlyData = isset($this->arParams['ONLY_DATA']) && $this->arParams['ONLY_DATA'] !== 'N';
		return $filterRequest;
	}
}
