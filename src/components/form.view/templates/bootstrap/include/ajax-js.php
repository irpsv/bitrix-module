<?php

$labels = array_column($fields, 'LABEL', 'NAME');
$successText = $arParams['SUCCESS_TEXT'] ?? "Данные успешно отправлены";

?>
<script type="text/javascript">
	window.formViewList = window.formViewList || {};
	window.formViewList['<?= $htmlId ?>'] = new FormView(<?= json_encode([
		'labels' => $labels,
		'selector' => "#{$htmlId}",
		'successText' => $successText,
	]) ?>);
</script>
