<?php

$type = $field['TYPE'];
$name = $field['NAME'];
$label = $field['LABEL'];
$value = $field['VALUE'];

if (!isset($arParams['INPUT_CSS_CLASS'])) {
	$cssInputClass = "btn";
	if ($type === 'submit') {
		$cssInputClass .= " btn-primary";
	}
	else if ($type === 'reset') {
		$cssInputClass .= " btn-danger";
	}
	else {
		// pass
	}
}

echo "<button {$attrStr} id='{$id}' type='{$type}' name='{$name}' value='{$value}' class='{$cssInputClass}'>{$label}</button>";
