<?php

// include_once __DIR__.'/functions.php';
//
// use arteast_actions\components\classes\templates;
//
// $title = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, 'NAME');
// $preview = templates\componentIblockElementViewBootstrapCardGetFieldValue($row, '{this.PROPERTY_TITLE}');

// проброс значений в component_epilog
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

$row = $arResult['ROW'];
$props = $arResult['PROPS'];

$picture	= $row['PREVIEW_PICTURE'];
$title		= $row['NAME'];
$preview	= $row['PREVIEW_TEXT'];
$link		= $row['DETAIL_PAGE_URL'];
$buttons = [
	[
		'TEXT' => 'Подробнее',
	],
];

$styleClasses = $arParams['CSS_CLASS'] ?? '';

?>
<div id="<?= $arResult['HTML_ID'] ?>" class="bitrix_moduleIblockElementViewList <?= $styleClasses ?>">
    <div class="row">
        <div class="col-12 col-md-4">
			<div class="bitrix_moduleIblockElementViewList__image">
				<?php
				echo "<a href='{$link}'>
		            <img class='w-100' src='{$picture['SRC']}' alt='{$picture['ALT']}' title='{$picture['ALT']}'>
				</a>";
				?>
			</div>
        </div>
        <div class="col-12 col-md-8">
            <h5 class="bitrix_moduleIblockElementViewList__title">
                <?php
                echo "<a href='{$link}'>{$title}</a>";
                ?>
            </h5>
            <div class="bitrix_moduleIblockElementViewList__content">
                <?= $preview ?>
            </div>
            <?php if ($buttons): ?>
                <div class="bitrix_moduleIblockElementViewList__footer">
                    <?php
                    foreach ($buttons as $item) {
                        $link = $item['LINK'] ?? $row['DETAIL_PAGE_URL'];
                        echo "<a href='{$link}' class='btn btn-primary'>{$item['TEXT']}</a>";
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
