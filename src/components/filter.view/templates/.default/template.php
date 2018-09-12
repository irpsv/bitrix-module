<?php

$fields = $arResult['FIELDS'];
$requestName = $arResult['REQUEST_NAME'];

?>
<div class="filterView">
	<form method="get">
		<?php
		foreach ($fields as $field) {
			echo "<div class='filterView__item'>";
			$name = $field->name;
			$type = $field->getType();
			$fieldRequestName = $name ? ($requestName ? "{$requestName}[{$name}]" : $name) : "";

			if (empty($type) || $type === 'text') {
				include __DIR__.'/filter_item_text.php';
			}
			else if ($type === 'select') {
				include __DIR__.'/filter_item_select.php';
			}
			else if ($type === 'checkbox') {
				include __DIR__.'/filter_item_checkbox.php';
			}
			else if ($type === 'checkboxlist') {
				include __DIR__.'/filter_item_checkboxlist.php';
			}
			else if ($type === 'radiolist') {
				include __DIR__.'/filter_item_radiolist.php';
			}
			else if ($type === 'date') {
				include __DIR__.'/filter_item_date.php';
			}
			else if ($type === 'datetime') {
				include __DIR__.'/filter_item_datetime.php';
			}
			else {
				include __DIR__.'/filter_item_component.php';
			}
			echo "</div>";
		}
		?>
		<div class="filterView__btns">
			<button type="submit" class="filterViewBtn__apply">
				Применить
			</button>
			<button type="reset" class="filterViewBtn__reset">
				Сбросить
			</button>
		</div>
	</form>
</div>
