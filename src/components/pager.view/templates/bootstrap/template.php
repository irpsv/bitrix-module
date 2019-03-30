<?php

$pageNow = $arResult['PAGE_NOW'];
$pageSize = $arResult['PAGE_SIZE'];
$pageMax = $arResult['PAGE_MAX'];
$requestName = $arResult['REQUEST_NAME'];

if ($pageMax < 2) {
	return;
}

$pagesViewedCount = (int) ($arParams['PAGES_VIEWED_COUNT'] ?? 1);
if ($pagesViewedCount > 0 && $pagesViewedCount < $pageMax) {
	$leftRange = floor($pagesViewedCount / 2);
	if ($leftRange < 1) {
		$leftRange = 1;
	}

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
	if ($beginRangeValue > 3) {
		array_unshift($pages, [
			'...' => ceil(($beginRangeValue - 1) / 2),
		]);
		array_unshift($pages, 1);
	}
	else if ($beginRangeValue == 3) {
		array_unshift($pages, 2);
		array_unshift($pages, 1);
	}
	else if ($beginRangeValue == 2) {
		array_unshift($pages, 1);
	}

	if (($pageMax - $endRangeValue) > 2) {
		array_push($pages, [
			'...' => $endRangeValue + floor(($pageMax - $endRangeValue) / 2),
		]);
		array_push($pages, $pageMax);
	}
	else if (($pageMax - $endRangeValue) == 2) {
		array_push($pages, $pageMax - 1);
		array_push($pages, $pageMax);
	}
	else if (($pageMax - $endRangeValue) == 1) {
		array_push($pages, $pageMax);
	}
}
else {
	$pages = range(1, $pageMax, 1);
}

?>
<div class="pagerView">
	<ul class="pagination justify-content-center">
		<?php
		// $params = $_GET;
		$params = [];
		if ($pageNow > 1) {
			$params[$requestName] = $pageNow - 1;
			$link = http_build_query($params);
			echo "<li class='page-item'><a class='page-link' href='?{$link}'>&laquo;</a></li>";
		}
		else {
			echo "<li class='page-item disabled'><a class='page-link' href='javascript:;'>&laquo;</a></li>";
		}

		foreach ($pages as $page) {
			if (is_array($page)) {
				$label = key($page);
				$page = current($page);
				$params[$requestName] = $page;
				$link = http_build_query($params);
				echo "<li class='page-item'><a class='page-link' href='?{$link}'>{$label}</a></li>";
			}
			else {
				$params[$requestName] = $page;
				$link = http_build_query($params);
				$active = $page == $pageNow ? "active" : "";
				echo "<li class='page-item {$active}'><a class='page-link' href='?{$link}'>{$page}</a></li>";
			}
		}

		if ($pageMax > $pageNow) {
			$params[$requestName] = $pageNow + 1;
			$link = http_build_query($params);
			echo "<li class='page-item'><a class='page-link' href='?{$link}'>&raquo;</a></li>";
		}
		else {
			echo "<li class='page-item disabled'><a class='page-link' href='javascript:;'>&raquo;</a></li>";
		}
		?>
	</ul>
</div>
