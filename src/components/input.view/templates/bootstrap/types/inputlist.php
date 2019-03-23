<?php

$name = $field['NAME'];
if ($field['MULTIPLE']) {
	$name = "{$field['NAME']}[]";
}

$value = $field['VALUE'];
$values = $field['VALUES'];

$isAssocValues = $field['IS_ASSOC_VALUES'];
$inputListType = $field['MULTIPLE'] ? 'checkbox' : 'radio';

$i = 0;
echo "<div {$attrStr} id='{$id}'>";
foreach ($values as $optionValue => $optionLabel) {
	if (!$isAssocValues) {
		$optionValue = $optionLabel;
	}
	if (is_array($value)) {
		$checked = in_array($optionValue, $value) ? "checked" : "";
	}
	else {
		$checked = $value == $optionValue ? "checked" : "";
	}

	$i++;
	echo "<div class='form-check'>
	<input type='{$inputListType}' id='{$id}_{$i}' name='{$name}' value='{$optionValue}' class='form-check-input' {$readonly} {$checked}>
	<label for='{$id}_{$i}' class='form-check-label'>{$optionLabel}</label>
	</div>";
}
echo "</div>";
