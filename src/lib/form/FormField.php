<?php

class FormField
{
	public $name;
	public $label;
	public $value;
	public $options = [];
	public $validators = [];

	public function __construct(array $config = [])
	{
		$keys = ['name', 'label', 'value', 'options', 'validators'];
		foreach ($config as $key => $value) {
			$key = mb_strtolower($key);
			if (in_array($key, $keys)) {
				$this->$key = $value;
			}
		}
	}
}
