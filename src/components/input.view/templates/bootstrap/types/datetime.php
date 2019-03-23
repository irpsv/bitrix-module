<?php

\CJSCore::Init([
	"date"
]);

$name = $field['NAME'];
$value = $field['VALUE'];
$placeholder = $field['PLACEHOLDER'];

$bTime = $isViewTime ? "true" : "false";

echo "<input
	{$attrStr}
	id='{$id}'
	type='text'
	name='{$name}'
	value='{$value}'
	placeholder='{$placeholder}'
	class='{$cssInputClass}'
	{$required}
	{$readonly}
	onclick='BX.calendar({node: this, field: this, bTime: {$bTime}});'
>";
