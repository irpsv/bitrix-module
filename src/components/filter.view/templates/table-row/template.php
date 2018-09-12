<?php

$fields = $arResult['FIELDS'];
$requestName = $arResult['REQUEST_NAME'];

?>
<tr class="filterViewTableRow">
	<?php
	foreach ($fields as $field) {
		echo "<td class='filterViewTableRow__item'>";
		$name = $field->name;
		$type = $field->getType();
		$fieldRequestName = $name ? ($requestName ? "{$requestName}[{$name}]" : $name) : "";

		if (empty($type) || $type === 'text') {
			include __DIR__.'/filter_item_text.php';
		}
		else if (in_array($type, ['select', 'checkboxlist', 'radiolist'])) {
			include __DIR__.'/filter_item_select.php';
		}
		else if ($type === 'checkbox') {
			include __DIR__.'/filter_item_checkbox.php';
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
		echo "</td>";
	}
	?>
	<td>
		<button type="submit">
			Применить
		</button>
	</td>
</tr>
