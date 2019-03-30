<?php

// проброс значений в component_epilog
$templateData['ROW'] = $arResult['ROW'];
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];
$templateData['CANONICAL'] = $arResult['CANONICAL'];
$templateData['SEO_VALUES'] = $arResult['SEO_VALUES'];
$templateData['SECTION_TREE'] = $arResult['SECTION_TREE'];

$row = $arResult['ROW'];

$title = $row['NAME'];
$desc = $row['DESCRIPTION'];

$styleClasses = $arParams['CSS_CLASS'] ?? '';

?>
<div id="<?= $arResult['HTML_ID'] ?>" class="bitrixModuleCssIblockSectionViewDetail <?= $styleClasses ?>">
	<div class="bitrixModuleCssIblockSectionViewDetail__childs">
		<?php
		$elementParams = [
			'CACHE_TYPE' => 'N',
			'IBLOCK' => [
				'FILTER' => [
					'ACTIVE' => 'Y',
					'ACTIVE_DATE' => 'Y',
					'IBLOCK_ID' => $row['IBLOCK_ID'],
					'SECTION_ID' => $row['ID'],
					'CHECK_PERMISSIONS' => 'N',
				],
				'ORDER' => [
					'ACTIVE_FROM' => 'DESC',
				],
			],
			'COLS' => '1',
			'ITEM_TEMPLATE' => 'list-item',
			'PAGER_TEMPLATE' => 'bootstrap',
			'PAGER_PARAMS' => [
				'REQUEST_NAME' => 'p',
				'PAGE_SIZE' => 3,
			],
		];
		$elementParams = array_merge(
			$elementParams,
			(array) ($arParams['ELEMENT_LIST_PARAMS'] ?? [])
		);
		$APPLICATION->IncludeComponent("bitrix.module:iblock.element.list", "grid", $elementParams, $component);
		?>
	</div>
</div>
