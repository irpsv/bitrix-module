<?php

global $APPLICATION;

$params = $arParams['TYPE_COMPONENT_PARAMS'] ?? [];
$params['FIELD'] = $field;
$template = $params['TEMPLATE'] ?? '';

$APPLICATION->IncludeComponent($type, $template, $params, $component);
