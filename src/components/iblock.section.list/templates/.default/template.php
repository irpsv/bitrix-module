<div class="iblockSectionList">
	<?php
	$result = $arResult['RESULT'];
	$isOnlyId = $arResult['IS_ONLY_ID'];
	$itemTemplate = $arParams['ITEM_TEMPLATE'] ?? '';
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

		echo "<div class='iblockSectionList__item'>";
		$APPLICATION->IncludeComponent('bitrix_module:iblock.section.view', $itemTemplate, $itemParams, $component);
		echo "</div>";
	}
	?>
</div>
