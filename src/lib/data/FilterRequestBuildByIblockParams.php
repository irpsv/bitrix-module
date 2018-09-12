<?php

namespace bitrix_module\data;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\PropertyEnumerationTable;

class FilterRequestBuildByIblockParams
{
	public static function runStatic(...$args)
	{
		$self = new self(...$args);
		return $self->run();
	}

	public function __construct(int $iblockId, array $fields = [])
	{
		\CModule::includeModule('iblock');

		$this->fields = $fields;
		$this->iblockId = $iblockId;
	}

	public function run()
	{
		if (empty($this->fields)) {
			$this->initIblockFields();
		}

		$filter = new Filter();
		foreach ($this->fields as $fieldName) {
			if (stripos($fieldName, 'PROPERTY_') === 0) {
				$item = $this->processProperty($fieldName);
			}
			else {
				$item = $this->processField($fieldName);
			}

			$item = array_filter($item);
			if ($item) {
				$filter->addField($item);
			}
		}
		return new FilterRequest($filter);
	}

	public function getFieldLabels()
	{
		return [
			'ID' => 'ID',
			'TIMESTAMP_X' => 'Дата изменения',
			'MODIFIED_BY' => 'Изменен',
			'DATE_CREATE' => 'Дата создания',
			'CREATED_BY' => 'Создан',
			'ACTIVE_FROM' => 'Начало активности',
			'ACTIVE_TO' => 'Окончание активности',
			'NAME' => 'Название',
			'CODE' => 'Символьный код',
			'TAGS' => 'Теги',
			'PREVIEW_TEXT' => 'Описание для анонса',
			'DETAIL_TEXT' => 'Детальное описание',
			'SEARCHABLE_CONTENT' => '',
		];
	}

	public function processField(string $fieldName)
	{
		$item = [
			'NAME' => $fieldName,
			'LABEL' => $this->getFieldLabels()[$fieldName] ?? null,
		];
		if ($this->isDateTimeField($fieldName)) {
			$item['TYPE'] = 'datetime';
		}
		else if ($this->isTextField($fieldName)) {
			$item['TYPE'] = 'text';
		}
		else {
			throw new \Exception("Для поля '{$fieldName}' нет обработчика");
		}
		return $item;
	}

	public function processProperty(string $fieldName)
	{
		$property = null;
		$rePropId = '/^property_(\d+)/i';
		$rePropCode = '/^property_(\w+)/i';
		if (preg_match($rePropId, $fieldName, $m)) {
			$property = $this->getProperty([
				'=ID' => $m[1],
			]);
		}
		else if (preg_match($rePropCode, $fieldName, $m)) {
			$property = $this->getProperty([
				'=CODE' => $m[1],
			]);
		}

		if (!$property) {
			return null;
		}

		$item = [
			'NAME' => $fieldName,
			'LABEL' => $property['NAME'],
			'MULTIPLE' => $property['MULTIPLE'] === 'Y',
		];
		if ($property['PROPERTY_TYPE'] === PropertyTable::TYPE_LIST) {
			$item['TYPE'] = 'select';
			$item['VALUES'] = $this->getPropertyEnumAsValues($property['ID']);
		}
		else if ($property['PROPERTY_TYPE'] === PropertyTable::TYPE_ELEMENT) {
			$item['TYPE'] = 'select';
			$item['VALUES'] = $this->getElementsAsValues($property['LINK_IBLOCK_ID']);
		}
		else if ($property['PROPERTY_TYPE'] === PropertyTable::TYPE_SECTION) {
			$item['TYPE'] = 'select';
			$item['VALUES'] = $this->getSectionsAsValues($property['LINK_IBLOCK_ID']);
		}
		else {
			$item['TYPE'] = 'text';
		}

		return $item;
	}

	public function getPropertyEnumAsValues($propertyId)
	{
		$rows = PropertyEnumerationTable::getList([
			'select' => [
				'ID',
				'VALUE',
			],
			'filter' => [
				'=PROPERTY_ID' => $propertyId,
			],
			'order' => [
				'SORT' => 'ASC',
				'VALUE' => 'ASC',
			],
		])->fetchAll();
		return array_column($rows, 'VALUE', 'ID');
	}

	public function getElementsAsValues($iblockId)
	{
		$rows = ElementTable::getList([
			'select' => [
				'ID',
				'NAME',
			],
			'filter' => [
				'=ACTIVE' => 'Y',
				'=IBLOCK_ID' => $iblockId,
			],
			'order' => [
				'SORT' => 'ASC',
				'NAME' => 'ASC',
			],
		])->fetchAll();
		return array_column($rows, 'NAME', 'ID');
	}

	public function getSectionsAsValues($iblockId)
	{
		$rows = SectionTable::getList([
			'select' => [
				'ID',
				'NAME',
			],
			'filter' => [
				'=ACTIVE' => 'Y',
				'=GLOBAL_ACTIVE' => 'Y',
				'=IBLOCK_ID' => $iblockId,
			],
			'order' => [
				'SORT' => 'ASC',
				'NAME' => 'ASC',
			],
		])->fetchAll();
		return array_column($rows, 'NAME', 'ID');
	}

	public function getProperty(array $filter)
	{
		$filter['=ACTIVE'] = 'Y';
		$filter['=IBLOCK_ID'] = $this->iblockId;

		return PropertyTable::getRow([
			'select' => [
				'ID',
				'NAME',
				'PROPERTY_TYPE',
				'MULTIPLE',
				'LINK_IBLOCK_ID',
			],
			'filter' => $filter,
		]);
	}

	public function initIblockFields()
	{
		$this->fields = [
			'ID',
			'TIMESTAMP_X',
			'MODIFIED_BY',
			'DATE_CREATE',
			'CREATED_BY',
			// 'ACTIVE',
			'ACTIVE_FROM',
			'ACTIVE_TO',
			'NAME',
			'CODE',
			'TAGS',
			'PREVIEW_TEXT',
			'DETAIL_TEXT',
			'SEARCHABLE_CONTENT',
		];
		$props = PropertyTable::getList([
			'select' => [
				'ID',
			],
			'filter' => [
				'=ACTIVE' => 'Y',
				'=IBLOCK_ID' => $this->iblockId,
			],
			'order' => [
				'SORT' => 'ASC',
			],
		])->fetchAll();
		foreach ($props as $prop) {
			$this->fields[] = "PROPERTY_".$prop['ID'];
		}
	}


	public function isTextField($fieldName)
	{
		return in_array($fieldName, [
			'ID',
			'MODIFIED_BY',
			'CREATED_BY',
			'NAME',
			'CODE',
			'TAGS',
			'PREVIEW_TEXT',
			'DETAIL_TEXT',
			'SEARCHABLE_CONTENT',
		]);
	}

	public function isDateTimeField($fieldName)
	{
		return in_array($fieldName, [
			'TIMESTAMP_X',
			'DATE_CREATE',
			'ACTIVE_FROM',
			'ACTIVE_TO',
		]);
	}
}
