<?php

namespace bitrix_module\form;

class ExampleForm extends BaseForm
{
	public $login;
	public $password;
	public $passwordRepeat;
	public $birthday;

    public function getFieldValidators()
    {
        return [
            'login' => [
                'required',
            ],
            'password' => [
                'required',
            ],
            'passwordRepeat' => [
                function($value, $name, $model) {
                    if ($model->password !== $model->passwordRepeat) {
                        $model->addError($name, "'password' и 'passwordRepeat' должны совпадать");
                        return false;
                    }
                    return true;
                },
            ],
			'birthday' => [
				function($value, $name, $model) {
					$format = "d.m.Y";
					if ($value && \DateTime::createFromFormat($format, $value) === false) {
						$model->addError($name, "Поле '{$name}' должно соответствовать формату: '{$format}'");
                        return false;
					}
					return true;
				}
			],
        ];
    }

	public static function getFieldsByComponent()
	{
		$fields = parent::getFieldsByComponent();
		$fields['birthday']['TYPE'] = 'bx_date';
		$fields['password']['TYPE'] = 'password';
		$fields['passwordRepeat']['TYPE'] = 'password';
		return $fields;
	}

    public function process(): bool
    {
        // process

        return true;
    }
}
