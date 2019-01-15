<?php

$fields = $arResult['FIELDS'];
$method = $arResult['METHOD'];
$requestName = $arResult['REQUEST_NAME'];

$isAjaxSend = isset($arParams['IS_AJAX_SEND']) && $arParams['IS_AJAX_SEND'] && $arParams['IS_AJAX_SEND'] !== 'N';
$isBitrixSessidCheck = isset($arParams['IS_BITRIX_SESSID_CHECK']) && $arParams['IS_BITRIX_SESSID_CHECK'] && $arParams['IS_BITRIX_SESSID_CHECK'] !== 'N';

$formFields = [];
foreach ($fields as $field) {
	$formFields[] = $field->toArray();
}

?>
<div class="filterView filterView_bootstrap">
	<?php
	$APPLICATION->IncludeComponent("bitrix.module:form.view", "bootstrap", [
		'CACHE_TYPE' => 'N',
		'ACTION_URL' => '',
		'FORM_NAME' => $requestName,
		'METHOD' => $method,
		'FIELDS' => $formFields,
		'BUTTONS' => [
			[
				'TYPE' => 'submit',
				'LABEL' => 'Применить',
			],
			[
				'TYPE' => 'reset',
				'LABEL' => 'Сбросить',
				'ATTRIBUTES' => [
					'data-reset-filter' => true,
				],
			],
		],
		'IS_AJAX_SEND' => $isAjaxSend ? 'Y' : 'N',
		'IS_BITRIX_SESSID_CHECK' => $isBitrixSessidCheck ? 'Y' : 'N',
	], $component);
	?>
</div>
