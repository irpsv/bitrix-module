<?php

$buttons = $arParams['BUTTONS'] ?? [];
if (empty($buttons)) {
	return;
	// $buttons = [
	// 	[
	// 		'TYPE' => 'submit',
	// 		'LABEL' => 'Отправить',
	// 		'GROUP_CSS_CLASS' => 'd-inline-block',
	// 	],
	// ];
}
else if (count($buttons) > 1) {
	foreach ($buttons as & $button) {
		if (!isset($button['GROUP_CSS_CLASS'])) {
			$button['GROUP_CSS_CLASS'] = 'd-inline-block';
		}
	}
	unset($button);
}

$groupButtonsCss = $formRowCssClass ?: "form-group";

echo "<div class='{$groupButtonsCss}'>";
foreach ($buttons as $button) {
	if ($formRowCssClass && !$button['GROUP_CSS_CLASS']) {
		$button['GROUP_CSS_CLASS'] = $formRowCssClass;
	}
	if ($formInputCssClass && !$button['INPUT_CSS_CLASS']) {
		$button['INPUT_CSS_CLASS'] = $formInputCssClass;
	}
	$APPLICATION->IncludeComponent("bitrix.module:input.view", "bootstrap", $button, $component);
}
echo "</div>";
