<?php

$label = $field['label'] ?? $field['name'];
$name = $field['htmlName'];
$value = $field['value'] ?? "";

echo "<label>{$label}</label>";
echo "<textarea name='{$name}' class='form-control' {$attrsHtml}>{$value}</textarea>";
