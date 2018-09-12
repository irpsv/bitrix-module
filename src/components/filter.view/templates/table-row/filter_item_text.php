<?php

$label = $field->getLabel();
$value = $field->value;

?>
<div class="filterViewItemTableRow__text">
	<label class="filterViewItemTableRow__label">
		<?= $label ?>
	</label>
	<input type="text" name="<?= $fieldRequestName ?>" value="<?= $value ?>">
</div>
