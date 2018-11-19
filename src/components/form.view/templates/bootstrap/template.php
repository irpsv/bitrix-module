<?php

$arParams['FORM_ROW_CSS_CLASS'] = $arParams['FORM_ROW_CSS_CLASS'] ?? "form-group";
$arParams['FORM_INPUT_CSS_CLASS'] = $arParams['FORM_INPUT_CSS_CLASS'] ?? "form-control";

$APPLICATION->IncludeComponent("arteast.feedback:form.view", "", $arParams, $component);
