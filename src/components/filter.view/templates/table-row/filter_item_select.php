<?php

$label = $field->getLabel();
$multiple = $field->multiple && $field->multiple !== 'N';
$activeValue = $field->value;
$values = $field->values ?: [];

?>
<div class="filterViewItemTableRow__select">
	<label class="filterViewItemTableRow__label">
		<?= $label ?>
	</label>
	<?php
	if ($multiple) {
		echo "<select name='{$fieldRequestName}[]'>";
	}
	else {
		echo "<select name='{$fieldRequestName}'>";
	}
	echo "<option></option>";
	$isAssocValuesArray = $field->isAssocArrayValues();
	foreach ($values as $value => $label) {
		if (!$isAssocValuesArray) {
			$value = $label;
		}
		if (is_array($activeValue)) {
			$selected = in_array($value, $activeValue) ? "selected" : "";
		}
		else {
			$selected = $activeValue == $value ? "selected" : "";
		}
		echo "<option value='{$value}' {$selected}>{$label}</option>";
	}
	echo "</select>";
	?>
</div>
