<?php

$agreementModel = null;
$agreementId = $arParams['AGREEMENT_ID'] ?? null;
$agreementLink = $arParams['AGREEMENT_LINK'] ?? null;
$agreementText = $arParams['AGREEMENT_TEXT'] ?? null;

if ($agreementId) {
    $agreementModel = new \Bitrix\Main\UserConsent\Agreement($agreementId);
    if ($agreementModel->getId() === null) {
        return;
    }
}
else if ($agreementLink) {
    // pass
}
else {
    return;
}

?>
<div class="formViewBootstrap__agreement form-group">
    <input type="checkbox" required>
    <label>
        <?php
        if ($agreementModel) {
            if (!$agreementText) {
                $agreementText = $agreementModel->getLabelText();
            }
            if (!$agreementText) {
                $agreementText = "Я согласен на обработку персональных данных";
            }

            $modalId = "formViewBootstrap__agreement".uniqid();
            echo "<a href='#{$modalId}' data-toggle='modal' data-target='#{$modalId}'>{$agreementText}</a>";
            echo "<div class='modal fade' id='{$modalId}' tabindex='100' role='dialog' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Закрыть'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            {$agreementModel->getText()}
                        </div>
                    </div>
                </div>
            </div>";

        }
        else if ($agreementLink) {
            if (!$agreementText) {
                $agreementText = "Я согласен на обработку персональных данных";
            }
            echo "<a href='{$agreementLink}' target='_blank'>{$agreementText}</a>";
        }
        ?>
    </label>
</div>
