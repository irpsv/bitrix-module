<?php

$label = $field->getLabel();
$value = $field->value;

?>
<div class="filterViewItem__checkbox">
	<label class="filterViewItem__label">
		<input type="checkbox" name="<?= $fieldRequestName ?>" value="<?= $value ?>">
		<span><?= $label ?></span>
	</label>
</div>
