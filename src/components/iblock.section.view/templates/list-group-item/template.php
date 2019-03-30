<?php

// проброс значений в component_epilog
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

$row = $arResult['ROW'];

$id = $templateData['HTML_ID'];
$name = $row['NAME'];
$link = $row['SECTION_PAGE_URL'];

$active = stripos($APPLICATION->GetCurPage(), $link) === 0 ? "active" : "";

echo "<a id='{$id}' href='{$link}' class='list-group-item list-group-item-action {$active}'>{$name}</a>";
