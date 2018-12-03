<?php

// проброс значений в component_epilog
$templateData['MODEL'] = $arResult['MODEL'];
$templateData['SECTION_TREE'] = $arResult['SECTION_TREE'];
$templateData['SEO_VALUES'] = $arResult['SEO_VALUES'];
$templateData['CANONICAL'] = $arResult['CANONICAL'];
$templateData['OPEN_GRAPH_TITLE'] = $arResult['OPEN_GRAPH_TITLE'];
$templateData['OPEN_GRAPH_DESCRIPTION'] = $arResult['OPEN_GRAPH_DESCRIPTION'];
$templateData['OPEN_GRAPH_IMAGE'] = $arResult['OPEN_GRAPH_IMAGE'];
$templateData['HTML_ID'] = $arResult['HTML_ID'];
$templateData['BUTTONS'] = $arResult['BUTTONS'];

// модель
$model = $arResult['MODEL'];

?>
<div class="modelElementView modelElementView_bootstrapCard">
    <div class="card">
        <img class="card-img-top" src="<?= $imageSrc ?>" alt="<?= $imageName ?>">
        <div class="card-header">
            Шапка
        </div>
        <div class="card-body">
            <h5 class="card-title">
                Заголовок
            </h5>
            <p class="card-text">
                Текст
            </p>
            <a href="javascript:;" class="btn btn-primary">
                Кнопка
            </a>
        </div>
        <div class="card-footer">
            Подвал
        </div>
    </div>
</div>
