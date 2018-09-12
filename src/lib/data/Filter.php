<?php

namespace bitrix_module\data;

class Filter
{
	protected $fields = [];

	public function __construct()
	{

	}

	public function addField($value)
	{
		if ($value instanceof FilterField) {
			$this->fields[$value->name] = $value;
		}
		else if (is_array($value)) {
			$this->addFieldByConfig($value);
		}
		else {
			$name = (string) $value;
			$value = new FilterField([
				'name' => $name,
			]);
			$this->fields[$name] = $value;
		}
	}

	public function addFieldByConfig(array $config)
	{
		$field = new FilterField($config);
		$name = $field->name;
		if (empty($name)) {
			throw new \Exception("Свойство 'name' поля фильтра - обязательно");
		}
		$this->fields[$name] = $field;
	}

	public function getField(string $name)
	{
		return $this->getFields()[$name] ?? null;
	}

	public function getFields()
	{
		return $this->fields;
	}

	public function getFieldsNames()
	{
		return array_keys($this->fields);
	}

	public function toArray()
	{
		$ret = [];
		foreach ($this->fields as $name => $field) {
			$ret[$name] = $field->toArray();
		}
		return $ret;
	}

	public function setValue(string $name, $value)
	{
		if (isset($this->fields[$name])) {
			$this->fields[$name]->setValue($value);
		}
	}

	public function getActive()
	{
		$ret = [];
		foreach ($this->fields as $name => $field) {
			$value = $field->value;
			if ($value) {
				$ret[$name] = $value;
			}
		}
		return $ret;
	}
}
