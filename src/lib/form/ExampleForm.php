<?php

namespace bitrix_module\form;

class ExampleForm extends BaseForm
{
    public $name;
    public $phone;

    public function getFieldValidators()
    {
        return [
            'name' => [
                'required',
            ],
            'email' => [
                'email',
            ],
            'phone' => [
                function($value, $name, $model) {
                    if (empty($value)) {
                        $model->addError($name, "Поле '{$name}' не может быть пустым");
                        return false;
                    }
                    return true;
                },
            ],
        ];
    }

    public function process(): bool
    {
        // process

        return true;
    }
}
