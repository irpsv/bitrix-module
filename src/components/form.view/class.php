<?php

namespace bitrix_module\components\classes;

class FormView extends \CBitrixComponent
{
	public function executeComponent()
	{
		$fields = $this->arParams['FIELDS'];
		if (empty($fields)) {
			throw new \Exception("Параметр 'FIELDS' обязателен");
		}

		$formName = $this->arParams['FORM_NAME'] ?? null;
		$method = strtolower($this->arParams['METHOD'] ?? 'get');
		$model = $this->getModel($method, $formName);
		if (!is_array($model)) {
			throw new \Exception("Параметр 'MODEL' может быть массивом или функцией возвращающей массив данных");
		}

		$this->arResult = [
			'MODEL' => $model,
			'FIELDS' => $this->prepareFields($fields, $model, $formName),
			'METHOD' => $method,
			'FORM_NAME' => $formName,
		];
		$this->includeComponentTemplate();
	}

	public function getModel($method, $formName)
	{
		$model = $this->arParams['MODEL'] ?? null;
		if ($model)	 {
			if (is_callable($model)) {
				$model = $model();
			}
		}
		else {
			$data = $method === 'get' ? $_GET : $_POST;
			$model = $formName ? ($data[$formName] ?? null) : $data;
		}
		if (empty($model)) {
			return [];
		}
		return $model;
	}

	public function prepareFields(array $fields, array $model, $formName)
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

			$name = $field['name'];
			$field['value'] = $model[$name] ?? $field['value'] ?? null;
			$field['validators'] = $field['validators'] ?? [];
			$field['htmlName'] = $name;
			if ($formName) {
				$field['htmlName'] = "{$formName}[{$name}]";
			}
			$ret[] = $field;
		}
		return $ret;
	}
}
