<?php

namespace bitrix_module\components\classes;

use bitrix_module\data\ItemViewComponent;

\CModule::includeModule('bitrix.module');

class IblockElementView extends ItemViewComponent
{
	public function getModelByFilter(array $filter)
	{
		return \CIBlockElement::getList([], $filter)->fetch();
	}

	public function getLastUpdate(array $filter)
	{
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
