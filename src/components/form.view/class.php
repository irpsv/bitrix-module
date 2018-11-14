<?php

namespace bitrix_module\components\classes;

class FormView extends \CBitrixComponent
{
	public function executeComponent()
	{
		$fields = $this->arParams['FIELDS'] ?? null;
		if (empty($fields)) {
			throw new \Exception("Параметр 'FIELDS' обязателен");
		}

		$method = $this->arParams['METHOD'] ?? 'post';
		$formName = $this->arParams['FORM_NAME'] ?? null;
		$actionUrl = $this->arParams['ACTION_URL'] ?? '';

		$data = strtolower($method) === 'get' ? $_GET : $_POST;
		if ($formName) {
			$data = $data[$formName] ?? [];
		}

		$this->arResult = [
			'METHOD' => $method,
			'FIELDS' => $this->prepareFields($fields, $data),
			'FORM_NAME' => $formName,
			'ACTION_URL' => $actionUrl,
		];
		$this->includeComponentTemplate();
	}

	public function prepareFields(array $fields, $data)
	{
		foreach ($fields as & $field) {
			$field['TYPE'] = $field['TYPE'] ?? 'text';
			$field['VALUE'] = $field['VALUE'] ?? $data[$field] ?? null;
			$field['LABEL'] = $field['LABEL'] ?? $field['NAME'];
		}
		return $fields;
	}
}
