<?php

\CJSCore::Init([
	"jquery",
	"date",
]);

$label = $field->getLabel();
$value = $field->value;

?>
<div class="filterViewItem__date">
	<label class="filterViewItem__label">
		<?= $label ?>
	</label>
	<input type="text" name="<?= $fieldRequestName ?>" value="<?= $value ?>" onclick="BX.calendar({node: this, field: this, bTime: false});">
</div>
