<?php

use Bitrix\Main\Page\Asset;

$asset = Asset::getInstance();
$asset->addJs(SITE_TEMPLATE_PATH ."/assets/jquery/jquery.min.js");

$asset->addCss(SITE_TEMPLATE_PATH ."/assets/bootstrap/css/bootstrap-reboot.min.css");
$asset->addCss(SITE_TEMPLATE_PATH ."/assets/bootstrap/css/bootstrap-grid.min.css");
$asset->addCss("https://fonts.googleapis.com/css?family=Ubuntu:300,400,700&display=swap&subset=cyrillic");
$asset->addCss(SITE_TEMPLATE_PATH ."/assets/styles/main.css");