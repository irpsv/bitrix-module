<?php

\CModule::includeModule('iblock');

abstract class ModuleIblockBuilder
{
	protected $typeId;
	protected $iblockId;

	public function create()
	{
		$this->createType();
		$this->createIblock();
		$this->createProperties();
		$this->createSections($this->getSections());
		$this->createElements();
	}

	public function createType()
	{
		$params = $this->getType();
		$this->typeId = $params['ID'];

		$row = \CIBlockType::GetByID($this->typeId)->fetch();
		if ($row) {
			return;
		}

		$model = new \CIBlockType;
		$model->Add($params);
		if ($model->LAST_ERROR) {
			throw new \Exception($model->LAST_ERROR);
		}
	}

	public function createIblock()
	{
		$params = $this->getIblock();
		$params['IBLOCK_TYPE_ID'] = $this->typeId;
		$params['SITE_ID'] = $this->getSiteIds();

		$filter = [
			'TYPE' => $params['IBLOCK_TYPE_ID'],
			'CODE' => $params['CODE'],
		];
		$row = \CIBlock::getList([], $filter)->fetch();
		if ($row) {
			$this->iblockId = $row['ID'];
			return;
		}

		$model = new \CIBlock;
		$this->iblockId = $model->Add($params);
		if ($model->LAST_ERROR) {
			throw new \Exception($model->LAST_ERROR);
		}
	}

	public function createProperties()
	{
		$items = $this->getProperties();
		foreach ($items as $item) {
			$item['IBLOCK_ID'] = $this->iblockId;
			$filter = [
				'CODE' => $item['CODE'],
				'IBLOCK_ID' => $item['IBLOCK_ID'],
			];
			$row = \CIBlockProperty::getList([], $filter)->fetch();
			if ($row) {
				continue;
			}

			$model = new \CIBlockProperty;
			$model->Add($item);
			if ($model->LAST_ERROR) {
				throw new \Exception($model->LAST_ERROR);
			}
		}
	}

	public function createSections($items, $parentId = null)
	{
		foreach ($items as $item) {
			$item['IBLOCK_ID'] = $this->iblockId;
			$filter = [
				'NAME' => $item['NAME'],
				'IBLOCK_ID' => $item['IBLOCK_ID'],
			];
			if ($parentId) {
				$item['IBLOCK_SECTION_ID'] = $parentId;
				$filter['IBLOCK_SECTION_ID'] = $parentId;
			}
			$row = \CIBlockSection::getList([], $filter)->fetch();
			if ($row) {
				continue;
			}

			$childrens = $item['CHILDRENS'] ?? [];
			unset($item['CHILDRENS']);

			$model = new \CIBlockSection;
			$sectionId = $model->Add($item);
			if ($model->LAST_ERROR) {
				throw new \Exception($model->LAST_ERROR);
			}

			if ($childrens) {
				$this->createSections($childrens, $sectionId);
			}
		}
	}

	public function createElements()
	{
		$items = $this->getElements();
		foreach ($items as $item) {
			$item['IBLOCK_ID'] = $this->iblockId;
			// $filter = [
			// 	'NAME' => $item['NAME'],
			// 	'IBLOCK_ID' => $item['IBLOCK_ID'],
			// ];
			//
			// $row = \CIBlockElement::getList([], $filter)->fetch();
			// if ($row) {
			// 	continue;
			// }

			$sections = $item['SECTIONS'] ?? [];
			unset($item['SECTIONS']);

			$model = new \CIBlockElement;
			$elementId = $model->Add($item);
			if ($model->LAST_ERROR) {
				throw new \Exception($model->LAST_ERROR);
			}

			if ($sections) {
				$sectionIds = [];
				foreach ($sections as $sectionName) {
					$filter = [
						'NAME' => $sectionName,
						'IBLOCK_ID' => $this->iblockId,
					];
					$row = \CIBlockSection::getList([], $filter)->fetch();
					if ($row) {
						$sectionIds[] = $row['ID'];
					}
				}
				\CIBlockElement::SetElementSection($elementId, $sectionIds);
			}
		}
	}

	abstract public function getType();

	abstract public function getIblock();

	public function getProperties()
	{
		return [];
	}

	public function getElements()
	{
		return [];
	}

	public function getSections()
	{
		return [];
	}

	public function getPropertyValueIdByValue($code, $value)
	{
		$filter = [
			'CODE' => $code,
			'VALUE' => $value,
			'IBLOCK_ID' => $this->iblockId,
		];
		$row = \CIBlockPropertyEnum::getList([], $filter)->fetch();
		return $row ? $row['ID'] : null;
	}

	public function getSectionIdByName($name)
	{
		$filter = [
			'NAME' => $name,
			'IBLOCK_ID' => $this->iblockId,
		];
		$row = \CIBlockSection::getList([], $filter)->fetch();
		return $row ? $row['ID'] : null;
	}

	public function getIblockId()
	{
		$params = $this->getIblock();
		$filter = [
			'TYPE' => $this->typeId,
			'CODE' => $params['CODE'],
		];
		$row = \CIBlock::getList([], $filter)->fetch();
		return $row ? $row['ID'] : null;
	}

	public function getSiteIds()
	{
		$sites = \Bitrix\Main\SiteTable::getList([])->fetchAll();
		return array_column($sites, 'LID');
	}
}
