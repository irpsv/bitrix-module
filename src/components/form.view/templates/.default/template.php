<?php

$method = $arResult['METHOD'];
$action = $arResult['ACTION_URL'];
$fields = $arResult['FIELDS'];
$formName = $arResult['FORM_NAME'];

$buttonText = $arParams['BUTTON_TEXT'] ?? "Отправить";
$successText = $arParams['SUCCESS_TEXT'] ?? "Данные успешно отправлены";

$htmlId = "formView".uniqid();
$isAjax = isset($arParams['IS_AJAX_SEND']) && $arParams['IS_AJAX_SEND'] !== 'N' ? true : false;
$isBxssid = isset($arParams['IS_BITRIX_SESSID_CHECK']) && $arParams['IS_BITRIX_SESSID_CHECK'] !== 'N' ? true : false;
$isJsAlert = isset($arParams['IS_JS_ALERT']) && $arParams['IS_JS_ALERT'] !== 'N' ? true : false;

$formCssClass = $arParams['FORM_CSS_CLASS'] ?? "formView";
$formRowCssClass = $arParams['FORM_ROW_CSS_CLASS'] ?? "formView__row";
$formInputCssClass = $arParams['FORM_INPUT_CSS_CLASS'] ?? "formView__input";

?>
<div id="<?= $htmlId ?>" class="formView" data-ajax='<?= $isAjax ? 1 : 0 ?>' data-success='<?= $successText ?>'>
	<?php
	if ($isAjax) {
		echo "<form class='{$formCssClass}' action='{$action}' method='{$method}' name='{$formName}' onsubmit='return false;'>";
	}
	else {
		echo "<form class='{$formCssClass}' action='{$action}' method='{$method}' name='{$formName}'>";
	}
	?>
		<?php
		if ($isBxssid) {
			echo bitrix_sessid_post();
		}

		$inputTypes = [
			'text',
			'password',
			'checkbox',
			'radio',
			'color',
		];
		foreach ($fields as $field) {
			$type = $field['TYPE'];
			$name = $field['NAME'];
			if ($formName) {
				$name = "{$formName}[{$name}]";
			}

			$label = $field['LABEL'];
			$value = $field['VALUE'];
			$placeholder = $field['PLACEHOLDER'] ?? "";

			$isRequired = isset($field['REQUIRED']) && $field['REQUIRED'] !== 'N' ? true : false;
			$required = $isRequired ? "required" : "";

			echo "<div class='{$formRowCssClass} {$required}'>";
			if ($type === 'textarea') {
				include __DIR__.'/type/textarea.php';
			}
			else if ($type === 'select') {
				include __DIR__.'/type/select.php';
			}
			else if (in_array($type, $inputTypes)) {
				include __DIR__.'/type/input.php';
			}
			else {
				$template = $field['TEMPLATE'] ?? "";
				$params = $field;
				$APPLICATION->IncludeComponent($type, $template, $params);
			}
			echo "</div>";
		}
		?>
		<?php
		include __DIR__.'/include/agreement.php';
		?>
		<div class="formView__buttons <?= $formRowCssClass ?>">
			<button type="submit" class="btn btn-primary">
				<?= $buttonText ?>
			</button>
		</div>

		<?php if (!$isJsAlert): ?>
			<div class="formView__alert alert <?= $formRowCssClass ?>">

			</div>
		<?php endif; ?>
	</form>
</div>
<?php
$labels = array_column($fields, 'LABEL', 'NAME');
?>
<script type="text/javascript">
	window.formView = window.formView || {};
	window.formView['<?= $htmlId ?>'] = <?= json_encode([
		'labels' => $labels,
		'isJsAlert' => $isJsAlert,
	]) ?>;
</script>
