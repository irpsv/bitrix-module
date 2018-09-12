<?php

$label = $field->getLabel();
$value = $field->value;

?>
<div class="filterViewItem__text">
	<label class="filterViewItem__label">
		<?= $label ?>
	</label>
	<input type="text" name="<?= $fieldRequestName ?>" value="<?= $value ?>">
</div>
