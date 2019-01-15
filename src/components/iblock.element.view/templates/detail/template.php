<?php

// проброс значений в component_epilog
$templateData['ROW'] = $arResult['ROW'];
$templateData['SECTION_TREE'] = $arResult['SECTION_TREE'];
$templateData['SEO_VALUES'] = $arResult['SEO_VALUES'];
$templateData['CANONICAL'] = $arResult['CANONICAL'];
$templateData['OPEN_GRAPH_TITLE'] = $arResult['OPEN_GRAPH_TITLE'];
$templateData['OPEN_GRAPH_DESCRIPTION'] = $arResult['OPEN_GRAPH_DESCRIPTION'];
$templateData['OPEN_GRAPH_IMAGE'] = $arResult['OPEN_GRAPH_IMAGE'];
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

$row = $arResult['ROW'];
$title = $row['NAME'];
$image = $row['DETAIL_PICTURE'] ?: $row['PREVIEW_PICTURE'];
$content = $row['DETAIL_TEXT'] ?: $row['PREVIEW_TEXT'];
$dateTime = $row['TIMESTAMP_X'];

?>
<div class="modelElementView modelElementView_detail">
    <h1 class="page-title">
		<?= $title ?>
	</h1>
	<div class="mb-4">
		<img class="w-100" src="<?= $image['SRC'] ?>" alt="<?= $image['ALT'] ?>">
	</div>
	<div class="mb-4">
		<?= $content ?>
	</div>
	<hr>
	<div class="mb-4">
		<?= $dateTime ?>
	</div>
</div>
