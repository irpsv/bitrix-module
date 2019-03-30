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
<div id="<?= $arResult['HTML_ID'] ?>" class="bitrixModuleCssIblockElementListGrid">
	<div class="row">
		<?php if ($isViewFilter): ?>
			<div class="col-12 col-lg-4 col-xl-3">
				<div class="bitrixModuleCssIblockElementListGrid__filter">
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
				<div class="bitrixModuleCssIblockElementListGrid__content">
					<?php if ($sorterRequest && !$sorterRequest->isOnlyData): ?>
						<div class="bitrixModuleCssIblockElementListGrid__sorter">
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

					<div class="bitrixModuleCssIblockElementListGrid__items">
						<div class="row">
							<?php
							$items = $dataSet->getItems();
							$itemTemplate = $arParams['ITEM_TEMPLATE'] ?? 'bootstrap-card';
							$itemDefaultParams = $arParams['ITEM_PARAMS'] ?? [];
							if (empty($items)) {
								include __DIR__.'/empty.php';
							}

							$cols = (int) ($arParams['COLS'] ?? 3);
							$colXs = (int) ($arParams['COL_XS'] ?? 12);

							if ($cols == 4) {
								$colSm = (int) ($arParams['COL_SM'] ?? 6);
								$colMd = (int) ($arParams['COL_MD'] ?? 4);
								$colLg = (int) ($arParams['COL_LG'] ?? 3);
								$colXl = (int) ($arParams['COL_XL'] ?? 3);
							}
							else if ($cols == 3) {
								$colSm = (int) ($arParams['COL_SM'] ?? 6);
								$colMd = (int) ($arParams['COL_MD'] ?? 4);
								$colLg = (int) ($arParams['COL_LG'] ?? 4);
								$colXl = (int) ($arParams['COL_XL'] ?? 4);
							}
							else if ($cols == 2) {
								$colSm = (int) ($arParams['COL_SM'] ?? 6);
								$colMd = (int) ($arParams['COL_MD'] ?? 6);
								$colLg = (int) ($arParams['COL_LG'] ?? 6);
								$colXl = (int) ($arParams['COL_XL'] ?? 6);
							}
							else {
								$colSm = (int) ($arParams['COL_SM'] ?? 12);
								$colMd = (int) ($arParams['COL_MD'] ?? 12);
								$colLg = (int) ($arParams['COL_LG'] ?? 12);
								$colXl = (int) ($arParams['COL_XL'] ?? 12);
							}

							foreach ($items as $item) {
								$itemParams = array_merge(
									[
										'ID' => $item['ID'],
										'CACHE_TYPE' => 'N',
									],
									$itemDefaultParams
								);
								echo "<div class='col-{$colXs} col-sm-{$colSm} col-md-{$colMd} col-lg-{$colLg} col-xl-{$colXl}'>";
								$APPLICATION->IncludeComponent('bitrix.module:iblock.element.view', $itemTemplate, $itemParams, $component);
								echo "</div>";
							}
							?>
						</div>
					</div>

					<?php if ($pagerRequest && !$pagerRequest->isOnlyData): ?>
						<div class="bitrixModuleCssIblockElementListGrid__pager">
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
