<?php

$label = $field['label'] ?? $field['name'];
$name = $field['htmlName'];
$value = $field['value'] ?? "";
$type = $field['type'] ?? "text";

echo "<label>{$label}</label>";
echo "<input type='{$type}' name='{$name}' value='{$value}' class='form-control' {$attrsHtml}>";
