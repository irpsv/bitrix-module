<?php

// проброс переменных в component_epilog.php
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

// логика
$dataSet = $arResult['DATA_SET'];
$pagerRequest = $arResult['PAGER_REQUEST'];
$sorterRequest = $arResult['SORTER_REQUEST'];
$filterRequest = $arResult['FILTER_REQUEST'];

$isViewFilter = $filterRequest && !$filterRequest->isOnlyData;

?>
<div id="<?= $arResult['HTML_ID'] ?>" class="bitrix_moduleiblockElementListGrid">
	<div class="row">
		<?php if ($isViewFilter): ?>
			<div class="col-12 col-lg-4 col-xl-3">
				<div class="bitrix_moduleiblockElementListGrid__filter">
					<?php
					$filterParams = [
						'CACHE_TYPE' => 'N',
						'FILTER_REQUEST' => $filterRequest,
					];
					$filterTemplate = $arParams['FILTER_TEMPLATE'] ?? 'bootstrap';
					$APPLICATION->IncludeComponent("bitrix.module:filter.view", $filterTemplate, $filterParams, $component);
					?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($isViewFilter): ?>
			<div class="col-12 col-lg-8 col-xl-9">
		<?php else: ?>
			<div class="col-12">
		<?php endif; ?>
				<div class="bitrix_moduleiblockElementListGrid__content">
					<?php if ($sorterRequest && !$sorterRequest->isOnlyData): ?>
						<div class="bitrix_moduleiblockElementListGrid__sorter">
							<?php
							$sorterParams = [
								'CACHE_TYPE' => 'N',
								'SORTER_REQUEST' => $sorterRequest,
							];
							$sorterTemplate = $arParams['SORTER_TEMPLATE'] ?? 'bootstrap';
							$APPLICATION->IncludeComponent("bitrix.module:sorter.view", $sorterTemplate, $sorterParams, $component);
							?>
						</div>
					<?php endif; ?>

					<div class="bitrix_moduleiblockElementListGrid__items">
						<div class="row">
							<?php
							$items = $dataSet->getItems();
							$itemTemplate = $arParams['ITEM_TEMPLATE'] ?? 'bootstrap-card';
							$itemDefaultParams = $arParams['ITEM_PARAMS'] ?? [];
							if (empty($items)) {
								include __DIR__.'/empty.php';
							}

							$cols = (int) ($arParams['COLS'] ?? 3);
							if ($cols == 4) {
								$colSm = 6;
								$colMd = 4;
								$colLg = 3;
								$colXl = 3;
							}
							else if ($cols == 3) {
								$colSm = 6;
								$colMd = 4;
								$colLg = 4;
								$colXl = 4;
							}
							else if ($cols == 2) {
								$colSm = 6;
								$colMd = 6;
								$colLg = 6;
								$colXl = 6;
							}
							else {
								$colSm = 12;
								$colMd = 12;
								$colLg = 12;
								$colXl = 12;
							}

							foreach ($items as $item) {
								$itemParams = array_merge(
									[
										'ID' => $item['ID'],
										'CACHE_TYPE' => 'N',
									],
									$itemDefaultParams
								);
								echo "<div class='col-12 col-sm-{$colSm} col-md-{$colMd} col-lg-{$colLg} col-xl-{$colXl}'>";
								$APPLICATION->IncludeComponent('bitrix.module:iblock.element.view', $itemTemplate, $itemParams, $component);
								echo "</div>";
							}
							?>
						</div>
					</div>

					<?php if ($pagerRequest && !$pagerRequest->isOnlyData): ?>
						<div class="bitrix_moduleiblockElementListGrid__pager">
							<?php
							$pagerParams = [
								'CACHE_TYPE' => 'N',
								'PAGER_REQUEST' => $pagerRequest,
							];
							$pagerTemplate = $arParams['PAGER_TEMPLATE'] ?? 'bootstrap';
							$APPLICATION->IncludeComponent("bitrix.module:pager.view", $pagerTemplate, $pagerParams, $component);
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
	</div>
</div>
