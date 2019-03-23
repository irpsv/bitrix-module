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
$content = $row['DESCRIPTION'];

?>
<div class="modelSectionView modelSectionView_detail">
    <h1 class="page-title">
		<?= $title ?>
	</h1>
    <div class="modelSectionView__content">
        <?= $content ?>
    </div>
    <div class="modelSectionView__childs">
        <?php
        $APPLICATION->IncludeComponent("bitrix.module:iblock.element.list", "grid", [
            'IBLOCK' => [
                'FILTER' => [
                    'IBLOCK_ID' => $row['IBLOCK_ID'],
                    'IBLOCK_SECTION_ID' => $row['ID'],
                    'ACTIVE' => 'Y',
                    'ACTIVE_DATE' => 'Y',
                    'CHECK_PERMISSIONS' => 'N',
                ],
            ],
        ], $component);
        ?>
    </div>
</div>
