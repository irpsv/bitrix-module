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
$image = $row['DETAIL_PICTURE'];
$content = $row['DETAIL_TEXT'];

?>
<div id="<?= $arResult['HTML_ID'] ?>" class="bitrix_moduleIblockElementViewDetail">
    <h1 class="bitrix_moduleIblockElementViewDetail__title">
		<?= $title ?>
	</h1>
    <?php if ($image): ?>
    <div class="bitrix_moduleIblockElementViewDetail__banner">
        <img class="w-100" src="<?= $image['SRC'] ?>" alt="<?= $image['ALT'] ?>">
    </div>
    <?php endif; ?>
	<div class="bitrix_moduleIblockElementViewDetail__content">
		<?= $content ?>
	</div>
</div>
