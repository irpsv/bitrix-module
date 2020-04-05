<?php

if ($APPLICATION->GetGroupRight("rpsv.main") == "D") {
	return false;
}

return [
	'parent_menu' => 'global_menu_content',
	'sort' => 100,
	'url' => 'value',
	'more_url' => [
		'url',
		'url',
		'url',
	],
	'text' => 'value',
	'title' => 'value',
	'icon' => 'value',
	'page_icon' => 'value',
	'module_id' => 'rpsv.main',
	'dynamic' => 'value',
	'items_id' => 'value',
	'items' => [
		[
			'url' => 'value',
			'text' => 'value',
			'items' => [

			],
		],
	],
];
