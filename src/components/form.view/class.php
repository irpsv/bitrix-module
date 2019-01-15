<?php

namespace bitrix_module\components\classes;

class FormView extends \CBitrixComponent
{
	public function executeComponent()
    {
		$method = $this->arParams['METHOD'] ?? 'post';
		$formName = $this->arParams['FORM_NAME'] ?? null;
		$data = strtolower($method) === 'get' ? $_GET : $_POST;
		if ($formName) {
			$data = $data[$formName] ?? [];
		}

        $cacheTime = $this->arParams['CACHE_TIME'] ?? 86400000;
		$cachePath = preg_replace('/[^a-z0-9]/i', '_', get_class($this));
        $cacheAdditionalId = serialize($data);

        if ($this->startResultCache($cacheTime, $cacheAdditionalId, $cachePath)) {
            $this->run($data);
            $this->endResultCache();
        }
    }

	public function run($data)
	{
		$fields = $this->arParams['FIELDS'] ?? null;
		if (empty($fields)) {
			throw new \Exception("Параметр 'FIELDS' обязателен");
		}

		$method = $this->arParams['METHOD'] ?? 'post';
		$formName = $this->arParams['FORM_NAME'] ?? null;
		$actionUrl = $this->arParams['ACTION_URL'] ?? '';

		$this->arResult = [
			'METHOD' => $method,
			'FIELDS' => $this->prepareFields($fields, $data, $formName),
			'FORM_NAME' => $formName,
			'ACTION_URL' => $actionUrl,
		];
		$this->includeComponentTemplate();
	}

	public function prepareFields(array $fields, $data, $formName)
	{
		foreach ($fields as & $field) {
			$fieldName = $field['NAME'];
			if ($fieldName) {
				$dataValue = $data[$fieldName] ?? null;
				$field['VALUE'] = $dataValue ?: ($field['VALUE'] ?? null);

				$fieldName = $formName ? "{$formName}[{$fieldName}]" : $fieldName;
				$field['NAME'] = $fieldName;
			}
		}
		return $fields;
	}
}
