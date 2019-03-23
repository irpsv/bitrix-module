<?php

namespace bitrix_module\components\classes\templates;

function componentIblockSectionViewGetFieldValue(array $row, $field)
{
	if (!$field) {
		return null;
	}
	else if (is_callable($field)) {
		return call_user_func($field, $row);
	}
	else {
		$fieldName = (string) $field;
		return $row[$fieldName] ?? null;
	}
}
