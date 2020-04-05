<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php";

$moduleId = "rpsv.main";
if ($APPLICATION->GetGroupRight($moduleId) == "D") {
    $APPLICATION->AuthForm("Не достаточно прав");
}
$APPLICATION->SetTitle("Заголовок");

$errors = [];
$success = [];

//
// process code
//

require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php";

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

require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php";
