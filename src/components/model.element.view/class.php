<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\ItemViewComponent;
use bitrix_module\model\ExampleModel;


\CModule::includeModule('bitrix_module');

class ModelElementView extends \CBitrixComponent
{
	use ItemViewComponent;

	public function getIblockParams()
	{
		return [
			'SELECT' => [
				'ID',
			],
			'FILTER' => [
				'ACTIVE' => 'Y',
				'IBLOCK_CODE' => '',
				'CHECK_PERMISSIONS' => 'N',
			],
		];
	}

	public function getModelByFilter(array $filter)
	{
		$iblockParams = $this->getIblockParams();
		$select = $iblockParams['SELECT'] ?? ['ID'];
		$filter = array_merge(
			$iblockParams['FILTER'] ?? [],
			$filter
		);
		$filter = ExampleModel::getMergedDefaultFilter($filter);
		return ExampleModel::getModel([], $filter);
	}

	public function getLastUpdate();
	{
		$filter = $this->getFilter();
		if (!$filter) {
			return null;
		}
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
