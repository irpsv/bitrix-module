<?php

$method = $arResult['METHOD'];
$action = $arResult['ACTION_URL'];
$fields = $arResult['FIELDS'];
$formName = $arResult['FORM_NAME'];

$htmlId = "formView".uniqid();
$isAjax = isset($arParams['IS_AJAX_SEND']) && $arParams['IS_AJAX_SEND'] === 'Y' ? true : false;
$isBxssid = isset($arParams['IS_BITRIX_SESSID_CHECK']) && $arParams['IS_BITRIX_SESSID_CHECK'] === 'Y' ? true : false;

$formCssClass = $arParams['FORM_CSS_CLASS'] ?? "form";
$formRowCssClass = $arParams['GROUP_CSS_CLASS'] ?? null;
$formInputCssClass = $arParams['INPUT_CSS_CLASS'] ?? null;

?>
<div id="<?= $htmlId ?>" class="jsFormView">
	<?php
	if ($isAjax) {
		echo "<form class='{$formCssClass}' action='{$action}' method='{$method}' name='{$formName}' onsubmit='return false;'>";
	}
	else {
		echo "<form class='{$formCssClass}' action='{$action}' method='{$method}' name='{$formName}'>";
	}
	if ($isBxssid) {
		echo bitrix_sessid_post();
	}

	foreach ($fields as $field) {
		if ($formRowCssClass && !$field['GROUP_CSS_CLASS']) {
			$field['GROUP_CSS_CLASS'] = $formRowCssClass;
		}
		if ($formInputCssClass && !$field['INPUT_CSS_CLASS']) {
			$field['INPUT_CSS_CLASS'] = $formInputCssClass;
		}
		$APPLICATION->IncludeComponent("bitrix.module:input.view", "bootstrap", $field, $component);
	}

	include __DIR__.'/include/buttons.php';
	include __DIR__.'/include/agreement.php';

	echo "<div class='jsFormViewResponse alert' style='display:none;'></div>";
	echo "</form>";
	?>
</div>
<?php
if ($isAjax) {
	include __DIR__.'/include/ajax-js.php';
}
?>
