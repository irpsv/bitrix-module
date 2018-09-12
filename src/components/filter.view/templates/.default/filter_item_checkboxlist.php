<?php

$label = $field->getLabel();
$activeValue = $field->value;
$values = $field->values ?: [];

?>
<div class="filterViewItem__checkboxList">
	<label class="filterViewItem__label">
		<?= $label ?>
	</label>
	<?php
	$isAssocValuesArray = $field->isAssocArrayValues();
	foreach ($values as $value => $label) {
		if (!$isAssocValuesArray) {
			$value = $label;
		}
		if (is_array($activeValue)) {
			$checked = in_array($value, $activeValue) ? "checked" : "";
		}
		else {
			$checked = $activeValue == $value ? "checked" : "";
		}

		echo "<div class='filterViewItem__checkboxListItem'>
		<label style='font-weight:400;'>
			<input type='checkbox' name='{$fieldRequestName}[]' value='{$value}' {$checked}>
			<span>{$label}</span>
		</label>
		</div>";
	}
	?>
</div>
