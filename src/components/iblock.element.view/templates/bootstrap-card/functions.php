<?php

namespace bitrix_module\components\classes\templates;

function componentIblockElementViewGetFieldValue(array $row, $field)
{
	if (!$field) {
		return null;
	}
	else if (is_callable($field)) {
		return call_user_func($field, $row);
	}
	else {
		$fieldName = (string) $field;
		$rePropId = '/^property_(\d+)/i';
		$rePropCode = '/^property_(\w+)/i';
		if (preg_match($rePropId, $fieldName, $m)) {
			$propertyFilter = [
				'=ID' => $m[1],
			];
		}
		else if (preg_match($rePropCode, $fieldName, $m)) {
			$propertyFilter = [
				'=CODE' => $m[1],
			];
		}
		else {
			return $row[$fieldName] ?? null;
		}

		$property = \CIBlockElement::getProperty(
			$row['IBLOCK_ID'],
			$row['ID'],
			[],
			$propertyFilter
		)->fetch();
		return $property ? $property['VALUE'] : null;
	}
}
