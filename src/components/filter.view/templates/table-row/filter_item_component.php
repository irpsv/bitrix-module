<?php

$componentName = $type;
$templateName = $this->getName();

?>
<div class="filterViewItemTableRow__component">
	<?php
	$APPLICATION->IncludeComponent($componentName, $templateName, [
		'FIELD' => $field,
		'REQUEST_NAME' => $arResult['REQUEST_NAME'],
	], $component);
	?>
</div>
