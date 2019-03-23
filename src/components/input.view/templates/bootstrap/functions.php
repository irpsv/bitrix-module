<?php

namespace bitrix_module\components\classes\templates;

function componentInputValueBuildAttributeStr(array $attributes)
{
	$attrStr = [];
	foreach ($attributes as $key => $value) {
		if ($key === 'data') {
			if (is_array($value)) {
				foreach ($value as $dataKey => $dataValue) {
					$htmlKey = htmlspecialchars("data-{$dataKey}");
					if (is_array($dataValue)) {
						$htmlValue = json_encode($dataValue);
					}
					else {
						$htmlValue = strval($dataValue);
					}
					$attrStr[] = "{$htmlKey}='".htmlspecialchars($htmlValue)."'";
				}
			}
		}
		else if ($key === 'style') {
			if (is_array($value)) {
				$styleValues = [];
				foreach ($value as $styleKey => $styleValue) {
					$styleValues[] = htmlspecialchars("{$styleKey}:{$styleValue}");
				}
				$attrStr[] = "style='".join(";", $styleValues)."'";
			}
			else {
				$attrStr[] = "style='".htmlspecialchars($value)."'";
			}
		}
		else {
			if (is_bool($value)) {
				$attrStr[] = htmlspecialchars($key);
			}
			else {
				$attrStr[] = htmlspecialchars($key)."='".htmlspecialchars($value)."'";
			}
		}
	}
	return join(" ", $attrStr);
}

function componentInputValueNormolizeMultipleValue(array $field)
{
	$field['MULTIPLE'] = isset($field['MULTIPLE']) && $field['MULTIPLE'] && $field['MULTIPLE'] !== 'N';
	return $field;
}
