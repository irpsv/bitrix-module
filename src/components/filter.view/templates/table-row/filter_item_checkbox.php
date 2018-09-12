<?php

$label = $field->getLabel();
$value = $field->value;

?>
<div class="filterViewItemTableRow__checkbox">
	<label class="filterViewItemTableRow__label">
		<input type="checkbox" name="<?= $fieldRequestName ?>" value="<?= $value ?>">
		<span><?= $label ?></span>
	</label>
</div>
