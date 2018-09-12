<?php

$labels = $arResult['LABELS'];
$fields = $arResult['FIELDS'];
$activeField = $activeSort = null;
$requestName = $arResult['REQUEST_NAME'];

if ($arResult['ACTIVE']) {
	$activeField = key($arResult['ACTIVE']);
	$activeSort = current($arResult['ACTIVE']);
}

$this->addExternalCss("https://use.fontawesome.com/releases/v5.3.1/css/all.css");

?>
<div class="sorterView">
	<?php
	$params = $_GET;
	foreach ($fields as $field) {
		$sort = "asc";
		$label = $labels[$field] ?? $field;
		if ($activeField == $field) {
			$sort = $activeSort === 'asc' ? 'desc' : 'asc';
			if ($activeSort === 'asc') {
				$label .= "<i class='fas fa-sort-up'></i>";
			}
			else {
				$label .= "<i class='fas fa-sort-down'></i>";
			}
		}
		else {
			$label .= "<i class='fas fa-sort'></i>";
		}

		$params[$requestName] = [
			$field => $sort
		];
		$link = http_build_query($params);
		echo "<div class='sorterView__item'><a href='?{$link}'>{$label}</a></div>";
	}
	?>
</div>
