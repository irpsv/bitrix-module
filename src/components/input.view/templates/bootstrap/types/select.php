<?php

$name = $field['NAME'];
if ($field['MULTIPLE']) {
	$name = "{$field['NAME']}[]";
}

$value = $field['VALUE'];
$values = $field['VALUES'];
$placeholder = $field['PLACEHOLDER'];

$isAssocValues = $field['IS_ASSOC_VALUES'];

echo "<select {$attrStr} id='{$id}' name='{$name}' placeholder='{$placeholder}' class='{$cssInputClass}' {$required} {$readonly}>";
if (!$required) {
	echo "<option value=''></option>";
}
foreach ($values as $optionValue => $optionLabel) {
	if (!$isAssocValues) {
		$optionValue = $optionLabel;
	}
	if (is_array($value)) {
		$selected = in_array($optionValue, $value) ? "selected" : "";
	}
	else {
		$selected = $value == $optionValue ? "selected" : "";
	}
	echo "<option value='{$optionValue}' {$selected}>{$optionLabel}</option>";
}
echo "</select>";
