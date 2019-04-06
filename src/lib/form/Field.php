<?php

namespace bitrix_module\form;

class Field
{
	protected $value;

	public $name;
	public $hint;
	public $type = 'text';
	public $label;
	public $error;
	public $values;
	public $success;
	public $multiple;
	public $placeholder;

	public function __construct(array $config = [])
	{
		foreach ($config as $key => $value) {
			$key = strtolower($key);
			if ($key === 'value') {
				$this->setValue($value);
			}
			else if (property_exists($this, $key)) {
				$this->$key = $value;
			}
		}
	}

	public function setValue($settedValue)
	{
		if ($this->values) {
			if (is_array($settedValue)) {
				$settedValue = array_map('strval', $settedValue);
				foreach ($settedValue as $item) {
					$this->setScalarValue($item);
				}
			}
			else {
				$this->setScalarValue((string) $settedValue);
			}
		}
		else {
			$this->value = $settedValue;
		}
	}

	public function getValue()
	{
		return $this->value;
	}

	public function isAssocArrayValues()
	{
		if (!is_array($this->values)) {
			return false;
		}

		$keys = array_keys($this->values);
		$range = range(0, max($keys), 1);
		if (count($keys) !== count($range)) {
			return true;
		}
		else if (array_diff($keys, $range)) {
			return true;
		}
		else {
			return false;
		}
	}

	public function setScalarValue(string $settedValue)
	{
		if (!$this->values) {
			$this->value = $settedValue;
			return;
		}

		$isAssoc = $this->isAssocArrayValues();
		foreach ($this->values as $key => $value) {
			if ($isAssoc) {
				$value = $key;
			}
			if ($settedValue == $value) {
				if ($this->multiple) {
					$this->value = (array) ($this->value ?: []);
					if (!in_array($settedValue, $this->value)) {
						$this->value[] = $settedValue;
					}
				}
				else {
					$this->value = $settedValue;
				}
				break;
			}
		}
	}

	public function toArray()
	{
		$ret = [];
		$ret['NAME'] = $this->name;
		$ret['HINT'] = $this->hint;
		$ret['TYPE'] = $this->type;
		$ret['ERROR'] = $this->error;
		$ret['LABEL'] = $this->label;
		$ret['VALUE'] = $this->getValue();
		$ret['VALUES'] = $this->values;
		$ret['SUCCESS'] = $this->success;
		$ret['MULTIPLE'] = $this->multiple;
		$ret['PLACEHOLDER'] = $this->placeholder;
		return $ret;
	}
	
	public function fromArray(array $row)
	{
		if ($row['NAME']) {
			$this->name = $row['NAME'];
		}
		if ($row['HINT']) {
			$this->hint = $row['HINT'];
		}
		if ($row['TYPE']) {
			$this->type = $row['TYPE'];
		}
		if ($row['ERROR']) {
			$this->error = $row['ERROR'];
		}
		if ($row['LABEL']) {
			$this->label = $row['LABEL'];
		}
		if ($row['VALUES']) {
			$this->values = $row['VALUES'];
		}
		if ($row['VALUE']) {
			$this->setValue($row['VALUE']);
		}
		if ($row['SUCCESS']) {
			$this->success = $row['SUCCESS'];
		}
		if ($row['MULTIPLE']) {
			$this->multiple = $row['MULTIPLE'];
		}
		if ($row['PLACEHOLDER']) {
			$this->placeholder = $row['PLACEHOLDER'];
		}
	}
}
