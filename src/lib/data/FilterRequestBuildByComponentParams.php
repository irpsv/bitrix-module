<?php

namespace arteast_fitness\data;

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

		$filter = null;
		$iblock = $this->arParams['IBLOCK'] ?? null;
		$active = (array) ($this->arParams['ACTIVE'] ?? []);
		$fields = $this->arParams['FIELDS'] ?? array_keys($active);

		if ($iblock && $fields) {
			$filter = FilterRequestBuildByIblockParams::runStatic(
				$this->getIblockId($iblock),
				$iblock['FIELDS']
			)->filter;
			foreach ($fields as $field) {
				if (is_array($field)) {
					// pass
				}
				else {
					$field = [
						'NAME' => (string) $field,
					];
				}

				$fieldName = $field['NAME'] ?? null;
				$existsField = $fieldName ? $filter->getField($fieldName) : null;
				if ($existsField) {
					$config = $existsField->toArray();
					if ($field instanceof FilterField) {
						$config = array_merge($config, $field->toArray());
					}
					else {
						$config = array_merge($config, $field);
					}
					$existsField->fromArray($config);
				}
				else {
					$filter->addField($field);
				}
			}
		}
		else if ($iblock) {
			$filter = FilterRequestBuildByIblockParams::runStatic(
				$this->getIblockId($iblock),
				$iblock['FIELDS']
			)->filter;
		}
		else if ($fields) {
			$filter = new Filter();
			foreach ($fields as $field) {
				$filter->addField($field);
			}
		}

		if ($filter) {
			$filterRequest = new FilterRequest($filter);
		}
		else {
			throw new \Exception("Параметр 'FIELDS' или 'IBLOCK' обязательны");
		}

		foreach ($active as $name => $value) {
			$filterRequest->filter->setValue($name, $value);
		}

		$filterRequest->queryName = (string) ($this->arParams['REQUEST_NAME'] ?? 'f');
		$filterRequest->isOnlyData = isset($this->arParams['ONLY_DATA']) && $this->arParams['ONLY_DATA'] !== 'N';
		return $filterRequest;
	}

	protected function getIblockId(array $iblock)
	{
		if (isset($iblock['ID'])) {
			return (int) $iblock['ID'];
		}
		else if (isset($iblock['CODE'])) {
			\CModule::includeModule('iblock');
			$row = \CIBlock::getList([], [
				'CODE' => $iblock['CODE'],
			])->fetch();
			if ($row) {
				return (int) $row['ID'];
			}
		}

		throw new \Exception("Параметры 'IBLOCK.ID' или 'IBLOCK.CODE' должны быть заполены");
	}
}
