<?php

namespace bitrix_module\data;

class SorterRequestBuildByComponentParams
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
		$sorterRequest = $this->arParams['SORTER_REQUEST'] ?? null;
		if ($sorterRequest instanceof SorterRequest) {
			return $sorterRequest;
		}
		else if ($sorterRequest) {
			throw new \Exception("Параметр 'SORTER_REQUEST' должен реализовывать класс ". SorterRequest::class);
		}
		else {
			// pass
		}

		$fields = (array) ($this->arParams['FIELDS'] ?? []);
		$active = (array) ($this->arParams['ACTIVE'] ?? []);
		if (!$fields && $active) {
			$fields = array_keys($active);
		}
		
		$sorter = new Sorter($fields);
		foreach ($active as $name => $sort) {
			$sorter->setActive($name, $sort);
		}
		$requestName = (string) ($this->arParams['REQUEST_NAME'] ?? 's');
		return new SorterRequest($sorter, $requestName);
	}
}
