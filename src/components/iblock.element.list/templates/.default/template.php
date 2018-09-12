<?php

$result = $arResult['RESULT'];
$pagerRequest = $arResult['PAGER_REQUEST'];
$sorterRequest = $arResult['SORTER_REQUEST'];
$filterRequest = $arResult['FILTER_REQUEST'];

?>
<div class="iblockElementList">
	<?php if ($filterRequest): ?>
		<div class="iblockElementList__aside">
			<div class="iblockElementList__filter">
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

	<div class="iblockElementList__content">
		<?php if ($sorterRequest): ?>
			<div class="iblockElementList__sorter">
				<?php
				$sorterParams = [
					'SORTER_REQUEST' => $sorterRequest,
				];
				$sorterTemplate = $arParams['SORTER_TEMPLATE'] ?? '';
				$APPLICATION->IncludeComponent("bitrix_module:sorter.view", $sorterTemplate, $sorterParams, $component);
				?>
			</div>
		<?php endif; ?>

		<div class="iblockElementList__items">
			<?php
			$isOnlyId = $arResult['IS_ONLY_ID'];
			$itemTemplate = $arParams['ITEM_TEMPLATE'] ?? '';
			if ($result->selectedRowsCount() < 1) {
				include __DIR__.'/empty.php';
			}
			while ($row = $result->fetch()) {
				if ($isOnlyId) {
					$itemParams = [
						'ID' => $row['ID'],
					];
				}
				else {
					$itemParams = [
						'ROW' => $row,
					];
				}

				echo "<div class='iblockElementList__item'>";
				$APPLICATION->IncludeComponent('bitrix_module:iblock.element.view', $itemTemplate, $itemParams, $component);
				echo "</div>";
			}
			?>
		</div>

		<?php if ($pagerRequest): ?>
			<div class="iblockElementList__pager">
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
