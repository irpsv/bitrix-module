<?php

namespace bitrix_module\data;

class FilterField
{
	protected $value;

	public $name;
	public $type;
	public $label;
	public $multiple;
	public $values;

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

	public function getType()
	{
		if ($this->type) {
			return $this->type;
		}
		else if ($this->values) {
			return 'select';
		}
		else {
			return 'text';
		}
	}

	public function getLabel()
	{
		return $this->label ?: $this->name;
	}

	public function toArray()
	{
		$ret = [];
		$ret['NAME'] = $this->name;
		$ret['TYPE'] = $this->getType();
		$ret['LABEL'] = $this->getLabel();
		$ret['VALUE'] = $this->getValue();
		$ret['VALUES'] = $this->values;
		$ret['MULTIPLE'] = $this->multiple;
		return array_filter($ret);
	}
}
