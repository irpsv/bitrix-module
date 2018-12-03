<?php

// проброс переменных в component_epilog.php
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

// логика
$dataSet = $arResult['DATA_SET'];
$pagerRequest = $arResult['PAGER_REQUEST'];
$sorterRequest = $arResult['SORTER_REQUEST'];
$filterRequest = $arResult['FILTER_REQUEST'];

?>
<div class="modelElementList">
	<div class="row">
		<?php if ($filterRequest): ?>
			<div class="col-12 col-lg-4 col-xl-3">
				<div class="modelElementList__filter">
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

		<div class="col-12 col-lg-8 col-xl-9">
			<div class="modelElementList__content">
				<?php if ($sorterRequest): ?>
					<div class="modelElementList__sorter">
						<?php
						$sorterParams = [
							'SORTER_REQUEST' => $sorterRequest,
						];
						$sorterTemplate = $arParams['SORTER_TEMPLATE'] ?? '';
						$APPLICATION->IncludeComponent("bitrix_module:sorter.view", $sorterTemplate, $sorterParams, $component);
						?>
					</div>
				<?php endif; ?>

				<div class="modelElementList__items">
					<div class="row">
						<?php
						$items = $dataSet->getItems();
						$itemTemplate = $arParams['ITEM_TEMPLATE'] ?? 'bootstrap-card';
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
							$itemParams = [
								'ID' => $item['ID'],
								'CACHE_TYPE' => 'Y',
							];
							echo "<div class='col-12 col-sm-{$colSm} col-md-{$colMd} col-lg-{$colLg} col-xl-{$colXl}'>";
							$APPLICATION->IncludeComponent('bitrix_module:model.element.view', $itemTemplate, $itemParams, $component);
							echo "</div>";
						}
						?>
					</div>
				</div>

				<?php if ($pagerRequest): ?>
					<div class="modelElementList__pager">
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
	</div>
</div>
