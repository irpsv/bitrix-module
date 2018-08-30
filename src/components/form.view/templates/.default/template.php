<?php

$action = $arParams['ACTION_URL'];
$method = $arResult['METHOD'];
$fields = $arResult['FIELDS'];
$formName = $arResult['FORM_NAME'];

$submitName = $arParams['BUTTON_LABEL'] ?? "Отправить";
$isBxssid = isset($arParams['USE_BXSSID']) && $arParams['USE_BXSSID'] === 'N' ? false : true;

?>
<div class="formView">
	<form action="<?= $action ?>" method="<?= $method ?>" name="<?= $formName ?>" onsubmit="return false;">
		<?php
		if ($isBxssid) {
			echo bitrix_sessid_post();
		}
		foreach ($fields as $field) {
			$type = $field['type'] ?? 'text';
			$attrs = [];
			if (in_array('required', $field['validators'])) {
				$attrs[] = ' required';
			}

			$options = $field['options'] ?? [];
			foreach ($field['options'] as $key => $value) {
				if (is_bool($value)) {
					$attrs[] = $key;
				}
				else {
					$key = htmlspecialchars($key);
					$value = htmlspecialchars($value);
					$attrs[] = "{$key}='{$value}'";
				}
			}
			$attrsHtml = join(" ", $attrs);

			echo "<div class='formView__item form-group'>";
			if ($type === 'textarea') {
				include __DIR__.'/type/textarea.php';
			}
			else if ($type === 'select') {
				include __DIR__.'/type/select.php';
			}
			else {
				include __DIR__.'/type/input.php';
			}
			echo "</div>";
		}
		?>
		<div class="formView__buttons form-group">
			<button type="submit" class="btn btn-primary">
				<?= $submitName ?>
			</button>
		</div>
		<div class="formView__alert alert">

		</div>
	</form>
</div>
