<?php

\CJSCore::Init([
	"jquery",
	"date",
]);

$label = $field->getLabel();
$value = $field->value;

?>
<div class="filterViewItemTableRow__date">
	<label class="filterViewItemTableRow__label">
		<?= $label ?>
	</label>
	<input type="text" name="<?= $fieldRequestName ?>" value="<?= $value ?>" onclick="BX.calendar({node: this, field: this, bTime: false});">
</div>
