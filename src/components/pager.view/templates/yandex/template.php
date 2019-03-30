<?php

$pageNow = $arResult['PAGE_NOW'];
$pageSize = $arResult['PAGE_SIZE'];
$pageMax = $arResult['PAGE_MAX'];
$requestName = $arResult['REQUEST_NAME'];

if ($pageMax < 2) {
	return;
}

$pagesViewedCount = 5;
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
}
else {
	$pages = range(1, $pageMax, 1);
}

?>
<div class="pagerViewYandex text-center">
	<div class="pagerViewYandex__pages d-none d-md-block">
		<?php
		// $params = $_GET;
		$params = [];
		if ($pageNow > 1) {
			$params[$requestName] = 1;
			$link = http_build_query($params);
			echo "<a class='pagerViewYandex__linkText' href='?{$link}'>В начало</a>";
		}

		foreach ($pages as $page) {
			$params[$requestName] = $page;
			$link = http_build_query($params);
			$active = $page == $pageNow ? "active bg-primary" : "";
			echo "<a class='pagerViewYandex__link {$active}' href='?{$link}'>{$page}</a>";
		}

		if ($pageMax > $pageNow) {
			$params[$requestName] = $pageNow + 1;
			$link = http_build_query($params);
			echo "<a class='pagerViewYandex__linkText' href='?{$link}'>дальше</a>";
		}
		?>
	</div>
	<div class="pagerViewYandex__mobile d-flex d-md-none">
		<?php
		$params = [];
		if ($pageNow > 1) {
			$params[$requestName] = $pageNow - 1;
			$link = http_build_query($params);
			echo "<a class='pagerViewYandex__linkText' href='?{$link}'>назад</a>";
		}
		else {
			echo "<a class='pagerViewYandex__linkText disabled' href='javascript:;'>начало</a>";
		}

		$params[$requestName] = $pageNow;
		$link = http_build_query($params);
		echo "<a class='pagerViewYandex__link active bg-primary' href='?{$link}'>{$pageNow}</a>";

		if ($pageMax > $pageNow) {
			$params[$requestName] = $pageNow + 1;
			$link = http_build_query($params);
			echo "<a class='pagerViewYandex__linkText' href='?{$link}'>дальше</a>";
		}
		else {
			echo "<a class='pagerViewYandex__linkText disabled' href='javascript:;'>конец</a>";
		}
		?>
	</div>
</div>
