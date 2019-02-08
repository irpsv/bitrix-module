<?php

$pageNow = $arResult['PAGE_NOW'];
$pageSize = $arResult['PAGE_SIZE'];
$pageMax = $arResult['PAGE_MAX'];
$requestName = $arResult['REQUEST_NAME'];

if ($pageMax < 2) {
	return;
}

$pagesViewedCount = (int) ($arParams['PAGES_VIEWED_COUNT'] ?? 5);
if ($pagesViewedCount > 0 && $pagesViewedCount < $pageMax) {
	$leftRange = floor($pagesViewedCount / 2);
	$beginRangeValue = $pageNow - $leftRange;
	$endRangeValue = $pageNow + $leftRange;

	if ($beginRangeValue < 1) {
		$endRangeValue += abs($beginRangeValue) + 1;
	}
	if ($endRangeValue > $pageMax) {
		$beginRangeValue -= abs($pageMax - $endRangeValue);
	}

	if ($beginRangeValue < 1) {
		$beginRangeValue = 1;
	}
	if ($endRangeValue > $pageMax) {
		$endRangeValue = $pageMax;
	}

	$pages = range($beginRangeValue, $endRangeValue, 1);
}
else {
	$pages = range(1, $pageMax, 1);
}

?>
<div class="pagerView">
	<ul class="pagination">
		<?php
		$params = $_GET;
		// if ($pageNow > 2) {
		// 	$params[$requestName] = 1;
		// 	$link = http_build_query($params);
		// 	echo "<li class='page-item'><a class='page-link' href='?{$link}'>Начало</a></li>";
		// }
		// else {
		// 	echo "<li class='page-item disabled'><a class='page-link' href='javascript:;'>Начало</a></li>";
		// }

		if ($pageNow > 1) {
			$params[$requestName] = 1;
			$link = http_build_query($params);
			echo "<li class='page-item'><a class='page-link' href='?{$link}'>Начало</a></li>";

			$params[$requestName] = $pageNow - 1;
			$link = http_build_query($params);
			echo "<li class='page-item'><a class='page-link' href='?{$link}'>&laquo;</a></li>";
		}
		else {
			echo "<li class='page-item disabled'><a class='page-link' href='javascript:;'>Начало</a></li>";
			echo "<li class='page-item disabled'><a class='page-link' href='javascript:;'>&laquo;</a></li>";
		}

		foreach ($pages as $page) {
			$params[$requestName] = $page;
			$link = http_build_query($params);
			$active = $page == $pageNow ? "active" : "";
			echo "<li class='page-item {$active}'><a class='page-link' href='?{$link}'>{$page}</a></li>";
		}

		if ($pageMax > $pageNow) {
			$params[$requestName] = $pageNow + 1;
			$link = http_build_query($params);
			echo "<li class='page-item'><a class='page-link' href='?{$link}'>&raquo;</a></li>";

			$params[$requestName] = $pageMax;
			$link = http_build_query($params);
			echo "<li class='page-item'><a class='page-link' href='?{$link}'>Конец</a></li>";
		}
		else {
			echo "<li class='page-item disabled'><a class='page-link' href='javascript:;'>&raquo;</a></li>";
			echo "<li class='page-item disabled'><a class='page-link' href='javascript:;'>Конец</a></li>";
		}
		//
		// if ($pageMax >= $pageNow + 2) {
		// 	$params[$requestName] = $pageMax;
		// 	$link = http_build_query($params);
		// 	echo "<li class='page-item'><a class='page-link' href='?{$link}'>Конец</a></li>";
		// }
		// else {
		// 	echo "<li class='page-item disabled'><a class='page-link' href='javascript:;'>Конец</a></li>";
		// }
		?>
	</ul>
</div>
