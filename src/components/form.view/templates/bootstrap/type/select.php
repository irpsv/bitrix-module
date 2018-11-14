<?php

$multiple = $field['MULTIPLE'] === 'Y' ? 'multiple' : '';
$values = $field['VALUES'] ?? [];
$size = $field['SIZE'] ?? ($multiple ? 5 : 1);

$isAssoc = ! empty(
    array_diff_assoc(
        range(0, count($values)-1),
        array_keys($values)
    )
);

echo "<label>{$label}</label>";
echo "<select name='{$name}' class='form-control' {$required} {$multiple} size='{$size}'>";
foreach ($values as $key => $value) {
    if (!$isAssoc) {
        $key = $value;
    }
    echo "<option value='{$key}'>{$value}</option>";
}
echo "</select>";
