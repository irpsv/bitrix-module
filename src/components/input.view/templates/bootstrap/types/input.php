<?php

$type = $field['TYPE'];
$name = $field['NAME'];
$value = $field['VALUE'];
$placeholder = $field['PLACEHOLDER'];

echo "<input {$attrStr} id='{$id}' type='{$type}' name='{$name}' value='{$value}' placeholder='{$placeholder}' class='{$cssInputClass}' {$required} {$readonly}>";
