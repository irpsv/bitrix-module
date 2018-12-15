<?php

namespace bitrix_module\components\classes;

use arteast_fitness\model\ExampleModel;
use arteast_fitness\data\DataSetComponent;
use arteast_fitness\data\IblockElementDataSet;

\CModule::includeModule('iblock');
\CModule::includeModule('bitrix_module');

class ModelElementList extends DataSetComponent
{
	public function getIblockParams()
	{
		return [
			'SELECT' => [
				'ID',
			],
			'FILTER' => [
				'ACTIVE' => 'Y',
				'ACTIVE_DATE' => 'Y',
				'IBLOCK_ID' => ExampleModel::getIblockId(),
				'CHECK_PERMISSIONS' => 'N',
			],
			'ORDER' => [
				'SORT' => 'ASC',
			],
		];
	}

	public function getDataSet()
	{
		$iblockParams = $this->getIblockParams();
		$filter = $iblockParams['FILTER'] ?? [];
		$select = $iblockParams['SELECT'] ?? ['ID'];
		$order = $iblockParams['ORDER'] ?? ['SORT' => 'ASC'];
		if (empty($filter)) {
			throw new \Exception("Фильтр инфоблока должен быть указан");
		}

		$dataSet = new IblockElementDataSet();
		$dataSet->setDefaultOrder($order);
		$dataSet->setDefaultFilter($filter);
		$dataSet->setSelect($select);
		return $dataSet;
	}

	public function getLastUpdate();
	{
		$filter = $this->getIblockParams()['FILTER'] ?? [];
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
