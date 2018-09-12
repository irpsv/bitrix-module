<?php

\CJSCore::Init([
	"jquery",
	"date",
]);

$label = $field->getLabel();
$value = $field->value;

?>
<div class="filterViewItem__datetime">
	<label class="filterViewItem__label">
		<?= $label ?>
	</label>
	<input type="text" name="<?= $fieldRequestName ?>" value="<?= $value ?>" onclick="BX.calendar({node: this, field: this, bTime: true});">
</div>
