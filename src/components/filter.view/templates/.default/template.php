<?php

CJSCore::Init([
	"jquery","date"
]);

$requestName = $arResult['REQUEST_NAME'];
$attributeNames = $arResult['NAMES'];
$attributeValues = $arResult['VALUES'];
$attributeActive = $arResult['ACTIVE'];
$valuesLabels = $arResult['VALUES_LABELS'];

?>
<div class="filterView">
	<form class="filterView__form" action="" method="get">
		<div class="filterView__fields">
			<?php
			foreach ($attributeNames as $name) {
				$label = GetMessage($name) ?: $name;
				$values = $attributeValues[$name] ?? null;
				$active = (array) ($attributeActive[$name] ?? []);
				$htmlName = "{$requestName}[{$name}]";

				echo "<div class='filterView__field {$name}'>";
				echo "<label>{$label}</label>";
				if ($name === "DATE_CREATE") {
					$active = $active[0] ?? "";
					echo "<input type='text' name='{$htmlName}' value='{$active}' class='form-control' onclick='BX.calendar({node: this, field: this, bTime: false});'>";
				}
				else if ($values) {
					echo "<select name='{$htmlName}' class='form-control'>";
					echo "<option></option>";
					foreach ($values as $value) {
						$label = $valuesLabels[$value] ?? $value;
						$selected = in_array($value, $active) ? "selected" : "";
						echo "<option {$selected} value='{$value}'>{$label}</option>";
					}
					echo "</select>";
				}
				else {
					$active = $active[0] ?? "";
					echo "<input type='text' name='{$htmlName}' value='{$active}' class='form-control'>";
				}
				echo "</div>";
			}
			?>
		</div>
		<div class="filterView__btns">
			<button type="submit" class="btn btn-primary">
				Применить
			</button>
			<button type="reset" class="btn btn-danger">
				Сбросить
			</button>
		</div>
	</form>
</div>
