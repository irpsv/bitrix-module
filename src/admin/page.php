<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php";

$moduleId = "moduleId";
if ($APPLICATION->GetGroupRight($moduleId) == "D") {
    $APPLICATION->AuthForm("Не достаточно прав");
}
$APPLICATION->SetTitle("Заголовок страницы");

$errors = [];
$success = [];

//
// process code
//

require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php";
?>

<?php
if ($errors) {
    CAdminMessage::ShowMessage([
        'MESSAGE' => 'В ходе работы возникли ошибки',
        'TYPE' => 'ERROR',
        'DETAILS' => join("<br>", $errors),
    ]);
}
if ($success) {
    CAdminMessage::ShowMessage([
        'MESSAGE' => 'Сохранение прошло успешно',
        'TYPE' => 'OK',
        'DETAILS' => join("<br>", $success),
    ]);
}
?>

<?php
$tabs = new CAdminTabControl("tabs", [
    [
        'DIV' => 'tab1',
        'TAB' => 'Вкладка',
        'TITLE' => 'Вкладка',
    ],
]);
$tabs->begin();
$tabs->beginNextTab();
?>

<form class="" action="" method="post">
    <tr>
        <td width="50%" class="adm-detail-content-cell-l">
            Название
        </td>
        <td width="50%" class="adm-detail-content-cell-r">
            Поле
        </td>
    </tr>
</form>

<?php
$tabs->buttons([]);
$tabs->end();

require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php";
?>
