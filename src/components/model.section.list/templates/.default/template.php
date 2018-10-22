<?php

$dataSet = $arResult['DATA_SET'];
$pagerRequest = $arResult['PAGER_REQUEST'];
$sorterRequest = $arResult['SORTER_REQUEST'];
$filterRequest = $arResult['FILTER_REQUEST'];

?>
<div class="iblockSectionList">
	<?php if ($filterRequest): ?>
		<div class="iblockSectionList__aside">
			<div class="iblockSectionList__filter">
				<?php
				$filterParams = [
					'FILTER_REQUEST' => $filterRequest,
				];
				$filterTemplate = $arParams['FILTER_TEMPLATE'] ?? '';
				$APPLICATION->IncludeComponent("bitrix_module:filter.view", $filterTemplate, $filterParams, $component);
				?>
			</div>
		</div>
	<?php endif; ?>

	<div class="iblockSectionList__content">
		<?php if ($sorterRequest): ?>
			<div class="iblockSectionList__sorter">
				<?php
				$sorterParams = [
					'SORTER_REQUEST' => $sorterRequest,
				];
				$sorterTemplate = $arParams['SORTER_TEMPLATE'] ?? '';
				$APPLICATION->IncludeComponent("bitrix_module:sorter.view", $sorterTemplate, $sorterParams, $component);
				?>
			</div>
		<?php endif; ?>

		<div class="iblockSectionList__items">
			<?php
			$items = $dataSet->getItems();
			$itemTemplate = $arParams['ITEM_TEMPLATE'] ?? '';
			if (empty($items)) {
				include __DIR__.'/empty.php';
			}
			foreach ($items as $item) {
				$itemParams = [
					'ROW' => $item,
				];
				echo "<div class='iblockSectionList__item'>";
				$APPLICATION->IncludeComponent('bitrix_module:model.section.view', $itemTemplate, $itemParams, $component);
				echo "</div>";
			}
			?>
		</div>

		<?php if ($pagerRequest): ?>
			<div class="iblockSectionList__pager">
				<?php
				$pagerParams = [
					'PAGER_REQUEST' => $pagerRequest,
				];
				$pagerTemplate = $arParams['PAGER_TEMPLATE'] ?? '';
				$APPLICATION->IncludeComponent("bitrix_module:pager.view", $pagerTemplate, $pagerParams, $component);
				?>
			</div>
		<?php endif; ?>
	</div>
</div>
