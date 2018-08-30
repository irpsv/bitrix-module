<?php

$pageNow = $arResult['PAGE_NOW'];
$pageSize = $arResult['PAGE_SIZE'];
$pageMax = $arResult['PAGE_MAX'];
$requestName = $arResult['REQUEST_NAME'];

if ($pageMax < 2) {
	return;
}

$pages = range(1, $pageMax, 1);

?>
<div class="pagerView">
	<ul class="pagination">
		<?php
		$params = $_GET;
		if ($pageNow > 2) {
			$params[$requestName] = 1;
			$link = http_build_query($params);
			echo "<li><a href='?{$link}'>&lt;&lt;</a></li>";
		}
		if ($pageNow > 1) {
			$params[$requestName] = $pageNow - 1;
			$link = http_build_query($params);
			echo "<li><a href='?{$link}'>&lt;</a></li>";
		}
		foreach ($pages as $page) {
			$params[$requestName] = $page;
			$link = http_build_query($params);
			$active = $page == $pageNow ? "active" : "";
			echo "<li class='{$active}'><a href='?{$link}'>{$page}</a></li>";
		}
		if ($pageMax >= $pageNow + 1) {
			$params[$requestName] = $pageNow + 1;
			$link = http_build_query($params);
			echo "<li><a href='?{$link}'>&gt;</a></li>";
		}
		if ($pageMax >= $pageNow + 2) {
			$params[$requestName] = $pageMax;
			$link = http_build_query($params);
			echo "<li><a href='?{$link}'>&gt;&gt;</a></li>";
		}
		?>
	</ul>
</div>
