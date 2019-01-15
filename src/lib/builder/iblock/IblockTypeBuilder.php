<?php

namespace bitrix_module\builder\iblock;

use bitrix_module\builder\general\BaseMapperBuilder;

class IblockTypeBuilder extends BaseMapperBuilder
{
	protected $typeId;

	public function __construct($typeId)
	{
		$this->typeId = $typeId;
	}

	public function getCreateCode()
	{
		\CModule::includeModule('iblock');

		$codes = [];
		$codes[] = $this->getCreateIblockTypeCode();
		// $codes[] = $this->getCreateIblockTypeLangCode();

		return join("\n\n", $codes);
	}

	public function getCreateIblockTypeCode()
	{
		$GLOBALS['CACHE_MANAGER']->CleanAll();

		$row = \Bitrix\Iblock\TypeTable::getRowById($this->typeId);
		if (!$row) {
			throw new \Exception("Не найден тип '{$this->typeId}' инфоблока");
		}

		$langs = [];
		$langRows = \Bitrix\Iblock\TypeLanguageTable::getList([
			'select' => [
				'LANGUAGE_ID',
				'NAME',
				'SECTIONS_NAME',
				'ELEMENTS_NAME',
			],
			'filter' => [
				'=IBLOCK_TYPE_ID' => $this->typeId,
			],
		])->fetchAll();
		foreach ($langRows as $langRow) {
			$lang = $langRow['LANGUAGE_ID'];
			unset($langRow['LANGUAGE_ID']);
			$langs[$lang] = $langRow;
		}
		$row['LANG'] = $langs;

		return $this->getCreateCodeByOldClass('\CIBlockType', $row);
	}

	// public function getCreateIblockTypeLangCode()
	// {
	// 	$codes = [];
	// 	$rows = \Bitrix\Iblock\TypeLanguageTable::getList([
	// 		'filter' => [
	// 			'=IBLOCK_TYPE_ID' => $this->typeId,
	// 		],
	// 	])->fetchAll();
	// 	foreach ($rows as $row) {
	// 		unset($row['ID']);
	// 		$codes[] = $this->getCreateCodeByMapper('\Bitrix\Iblock\TypeLanguageTable', $row);
	// 	}
	// 	return join("\n\n", $codes);
	// }

	public function getDeleteCode()
	{
		return trim("\\CIBlockType::Delete('{$this->typeId}');");
	}
}
