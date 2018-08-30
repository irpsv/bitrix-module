<?php

namespace module_id\components\classes;

class FormValidate extends \CBitrixComponent
{
	public function executeComponent()
	{
		$isBxssid = isset($arParams['USE_BXSSID']) && $arParams['USE_BXSSID'] === 'N' ? false : true;
		if ($isBxssid && !check_bitrix_sessid()) {
			return null;
		}

		$fields = $this->arParams['FIELDS'];
		if (empty($fields)) {
			throw new \Exception("Параметр 'FIELDS' обязателен");
		}

		$formName = $this->arParams['FORM_NAME'] ?? null;
		$method = $this->arParams['METHOD'] ?? 'get';
		$fields = $this->prepareFields($fields, $formName);
		$model = $this->getModel($fields, $method, $formName);
		if (empty($model)) {
			return null;
		}

		$errors = $this->validateModel($model, $fields);
		return [
			'model' => $model,
			'errors' => $errors,
		];
	}

	public function validateModel($model, $fields)
	{
		$errors = [];
		foreach ($fields as $field) {
			$name = $field['name'];
			$value = $model[$name] ?? null;
			$validators = $field['validators'] ?? [];
			foreach ($validators as $validator) {
				$isValid = $this->validateValue($value, $validator);
				if (!$isValid) {
					$errors[] = $this->getValidateErrorMessage($name, $value, $validator);
				}
			}
		}
		return $errors;
	}

	public function getValidateErrorMessage($name, $value, $validator)
	{
		if ($validator === 'required') {
			return "Поле '{$name}' обязательно для заполнения";
		}
		else if ($validator === 'email') {
			return "Поле '{$name}' должно быть email адресом";
		}
		else {
			return "Поле '{$name}' не соответствует требованию '{$validator}'";
		}
	}

	public function validateValue($value, $validator)
	{
		if ($validator === 'required') {
			return ! empty($value);
		}
		else if ($validator === 'email') {
			return check_email($value);
		}
		else {
			return false;
		}
	}

	public function getModel($fields, $method, $formName)
	{
		$request = strtolower($method) === 'get' ? $_GET : $_POST;
		$data = $formName ? ($request[$formName] ?? null) : $request;
		if (empty($data)) {
			return null;
		}

		$model = [];
		foreach ($fields as $field) {
			$name = $field['name'];
			$value = $field['value'] ?? null;

			$dataValue = $data[$name] ?? null;
			if ($dataValue) {
				$value = $dataValue;
			}

			$model[$name] = $value;
		}
		return $model;
	}

	public function prepareFields(array $fields, $formName)
	{
		$ret = [];
		foreach ($fields as $key => $value) {
			if (is_scalar($value)) {
				$field = [
					'name' => $key,
					'label' => $value,
					'type' => 'text',
				];
			}
			else if (is_array($value)) {
				$field = $value;
			}
			else {
				continue;
			}
			$ret[] = $field;
		}
		return $ret;
	}
}
