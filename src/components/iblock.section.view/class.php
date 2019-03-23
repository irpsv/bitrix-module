<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\ItemViewComponent;

\CModule::includeModule('bitrix.module');

class IblockSectionView extends ItemViewComponent
{
	public function getModelByFilter(array $filter)
	{
		return \CIBlockSection::getList([], $filter)->fetch();
	}

	public function getLastUpdate(array $filter)
	{
		$row = \CIBlockSection::getList(
			['TIMESTAMP_X' => 'DESC'],
			$filter,
			false,
			['TIMESTAMP_X']
		)->fetch();
		return $row ? $row['TIMESTAMP_X'] : null;
	}
}
