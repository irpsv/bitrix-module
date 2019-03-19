<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

\CModule::includeModule('bitrix.module');

$form = new \bitrix_module\form\ExampleForm;
$response = [];

if (check_bitrix_sessid()) {
    if ($form->load($_POST)) {
        if ($form->validate() && $form->process()) {
            $response['success'] = true;
        }
        else {
            $message = [];
            $errors = $form->getErrors();
            foreach ($errors as $key => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    $message[] = $error;
                }
            }
            $response['error'] = join("<br>", $message);
        }
    }
    else {
        $response['error'] = "Данные не отправлены";
    }
}
else {
    $response['error'] = "Некорректный токен безопасности";
}

echo json_encode($response);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");