<?php

$label = $field->getLabel();
$activeValue = $field->value;
$values = $field->values ?: [];

?>
<div class="filterViewItem__radioList">
	<label class="filterViewItem__label">
		<?= $label ?>
	</label>
	<?php
	$isFirst = true;
	$isAssocValuesArray = $field->isAssocArrayValues();
	foreach ($values as $value => $label) {
		if (!$isAssocValuesArray) {
			$value = $label;
		}
		if ($isFirst && !$activeValue) {
			$isFirst = false;
			$checked = "checked";
		}
		else {
			if (is_array($activeValue)) {
				$checked = in_array($value, $activeValue) ? "checked" : "";
			}
			else {
				$checked = $activeValue == $value ? "checked" : "";
			}
		}
		echo "<div class='filterViewItem__radioListItem'>
		<label style='font-weight:400;'>
			<input type='radio' name='{$fieldRequestName}' value='{$value}' {$checked}>
			<span>{$label}</span>
		</label>
		</div>";
	}
	?>
</div>
