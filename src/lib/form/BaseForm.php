<?php

// class RegisterForm extends BaseForm
// {
// 	public function getFields()
// 	{
// 		return [
// 			[
// 				'name' => 'login',
// 			],
// 			[
// 				'name' => 'password',
// 				'type' => 'password',
// 			],
// 			[
// 				'name' => 'password_repeat',
// 				'type' => 'password',
// 			],
// 			[
// 				'name' => 'fio',
// 				'type' => 'text',
// 			],
// 		];
// 	}
//
// 	public function process()
// 	{
// 		// pass
// 	}
// }
//
// $form = new RegisterForm();
// if ($form->validate()) {
// 	$form->process();
// }
// else {
// 	$errors = $form->getErrors();
// }

abstract class BaseForm
{
	protected $errors;

	abstract public function getFields();

	abstract public function process();

	public function getErrors()
	{
		return $this->errors;
	}

	public function validate()
	{

	}
}
