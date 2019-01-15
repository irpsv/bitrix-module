<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\DataSetComponent;
use bitrix_module\data\IblockElementDataSet;

\CModule::includeModule('iblock');
\CModule::includeModule('bitrix.module');

class IblockElementList extends DataSetComponent
{
	public function getIblockParams()
	{
		$iblockParams = $this->arParams['IBLOCK'];
		if (empty($iblockParams['FILTER'])) {
			throw new \Exception("Параметр `IBLOCK.FILTER` обязателен для заполнения");
		}
		return [
			'ORDER' => $iblockParams['ORDER'] ?? ['SORT' => 'ASC'],
			'FILTER' => $iblockParams['FILTER'],
		];
	}

	public function getDataSet()
	{
		$iblockParams = $this->getIblockParams();

		$dataSet = new IblockElementDataSet();
		$dataSet->setDefaultOrder($iblockParams['ORDER']);
		$dataSet->setDefaultFilter($iblockParams['FILTER']);
		$dataSet->setSelect(['ID']);
		return $dataSet;
	}

	public function getLastUpdate()
	{
		$filter = $this->getIblockParams()['FILTER'];
		$row = \CIBlockElement::getList(
			['TIMESTAMP_X' => 'DESC'],
			$filter,
			false,
			false,
			['TIMESTAMP_X']
		)->fetch();
		return $row ? $row['TIMESTAMP_X'] : null;
	}
}
