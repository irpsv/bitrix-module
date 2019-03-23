<?php

$name = $field['NAME'];
$value = $field['VALUE'];
$placeholder = $field['PLACEHOLDER'];

echo "<textarea {$attrStr} id='{$id}' name='{$name}' placeholder='{$placeholder}' class='{$cssInputClass}' {$required} {$readonly}>{$value}</textarea>";
