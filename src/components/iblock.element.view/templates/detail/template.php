<?php

// проброс значений в component_epilog
$templateData['ROW'] = $arResult['ROW'];
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];
$templateData['CANONICAL'] = $arResult['CANONICAL'];
$templateData['SEO_VALUES'] = $arResult['SEO_VALUES'];
$templateData['SECTION_TREE'] = $arResult['SECTION_TREE'];

$row = $arResult['ROW'];
$props = $arResult['PROPS'];

$title = $row['NAME'];
$image = $row['DETAIL_PICTURE'];
$content = $row['DETAIL_TEXT'];

$styleClasses = $arParams['CSS_CLASS'] ?? '';

?>
<div id="<?= $arResult['HTML_ID'] ?>" class="bitrixModuleCssIblockElementViewDetail <?= $styleClasses ?>">
    <h1 class="bitrixModuleCssIblockElementViewDetail__title">
		<?= $title ?>
	</h1>
    <?php if ($image): ?>
    <div class="bitrixModuleCssIblockElementViewDetail__banner">
        <img class="w-100" src="<?= $image['SRC'] ?>" alt="<?= $image['ALT'] ?>" title="<?= $image['TITLE'] ?>">
    </div>
    <?php endif; ?>
	<div class="bitrixModuleCssIblockElementViewDetail__content">
		<?= $content ?>
	</div>
</div>
