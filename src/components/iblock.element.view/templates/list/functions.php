<?php

namespace bitrix_module\components\classes\templates;

function componentIblockElementViewListGetFieldValue(array $row, $field)
{
	if (!$field) {
		return null;
	}
	else if (preg_match_all('/(\{this\.([\w\_\-]+)\})/', $field, $m)) {
		$replaces = $m[0];
		$fieldNames = $m[2];
		for ($i=0; $i<count($replaces); $i++) {
			$replace = $replaces[$i];
			$fieldName = $fieldNames[$i];
			$fieldValue = componentIblockElementViewListGetFieldValue($row, $fieldName);

			$field = str_replace($replace, $fieldValue, $field);
		}
		return htmlspecialchars_decode($field);
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
