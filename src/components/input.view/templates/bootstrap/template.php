<?php

include_once __DIR__.'/functions.php';

$id = "field".uniqid();
$field = $arResult['FIELD'];
$type = $field['TYPE'];

$required = $arParams['REQUIRED'] === 'Y' ? 'required' : null;
$readonly = $arParams['READONLY'] === 'Y' ? 'readonly' : null;

if ($type === 'hidden') {
	echo "<input id='{$id}' type='hidden' name='{$field['NAME']}' value='{$field['VALUE']}' {$required}>";
	return;
}

$cssGroupClass = $arParams['GROUP_CSS_CLASS'] ?? "form-group";
$cssInputClass = $arParams['INPUT_CSS_CLASS'] ?? "form-control";

if ($field['ERROR']) {
	$cssInputClass .= " is-invalid";
}
else if ($field['SUCCESS']) {
	$cssInputClass .= " is-valid";
}

$field = \bitrix_module\components\classes\templates\componentInputValueNormolizeMultipleValue($field);
$attrs = $arParams['ATTRIBUTES'] ?? [];
if ($field['MULTIPLE']) {
	$attrs['size'] = 10;
	$attrs['multiple'] = true;
}
$attrStr = \bitrix_module\components\classes\templates\componentInputValueBuildAttributeStr($attrs);

$withoutLabelTypes = [
	'radio',
	'switch',
	'checkbox',
	'submit',
	'button',
	'reset',
];

?>
<div class="<?= $cssGroupClass ?>">
	<?php
	if ($field['LABEL'] && !in_array($type, $withoutLabelTypes)) {
		echo "<label for='{$id}'>{$field['LABEL']}</label>";
	}
	switch ($type) {
		case 'switch':
			include __DIR__.'/types/switch.php';
			break;

		case 'select':
			include __DIR__.'/types/select.php';
			break;

		case 'list':
		case 'inputlist':
		case 'flags':
			include __DIR__.'/types/inputlist.php';
			break;

		case 'textarea':
			include __DIR__.'/types/textarea.php';
			break;

		case 'date':
		case 'bx_date':
			$isViewTime = false;
			include __DIR__.'/types/datetime.php';
			break;

		case 'datetime':
		case 'bx_datetime':
			$isViewTime = true;
			include __DIR__.'/types/datetime.php';
			break;

		case 'checkbox':
		case 'radio':
			include __DIR__.'/types/flag.php';
			break;

		case 'submit':
		case 'reset':
		case 'button':
			include __DIR__.'/types/button.php';
			break;

		case 'text':
		case 'file':
		case 'password':
		case 'color':
		// case 'date':
		// case 'datetime':
		case 'email':
		case 'number':
		case 'range':
		case 'tel':
		case 'time':
		case 'url':
		case 'month':
		case 'week':
			include __DIR__.'/types/input.php';
			break;

		default:
			include __DIR__.'/types/component.php';
			break;
	}
	if ($field['HINT']) {
		echo "<small class='form-text text-muted'>{$field['HINT']}</small>";
	}
	if ($field['ERROR']) {
		echo "<div class='invalid-feedback'>{$field['ERROR']}</div>";
		echo "<script>document.querySelector('#{$id}').setCustomValidity(' ');</script>";
	}
	else if ($field['SUCCESS']) {
		echo "<div class='valid-feedback'>{$field['SUCCESS']}</div>";
	}
	?>
</div>
