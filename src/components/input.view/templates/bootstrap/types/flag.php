<?php

$name = $field['NAME'];
$value = $field['VALUE'];
$label = $field['LABEL'];

echo "<div class='custom-control custom-{$type}'>
	<input type='{$type}' class='custom-control-input' id='{$id}' name='{$name}' value='{$value}' {$attrStr} {$required} {$readonly}>
	<label class='custom-control-label' for='{$id}'>{$label}</label>
</div>";
