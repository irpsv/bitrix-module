<?php

namespace bitrix_module\form;

abstract class BaseForm
{
    private $fieldNames;
    private $errors;

    abstract public function process(): bool;

    public function load(array $data)
    {
        $isLoad = false;
        $fieldNames = $this->getFieldNames();
        foreach ($fieldNames as $name) {
            if (isset($data[$name])) {
                $isLoad = true;
                $this->$name = $data[$name];
            }
        }
        return $isLoad;
    }

	public static function getFieldsByComponent()
	{
		$ret = [];
		$form = new static();
		$values = $form->getFieldValues();
		$validators = $form->getFieldValidators();

		foreach ($values as $name => $value) {
			$ret[$name] = [
				'TYPE' => 'text',
				'NAME' => $name,
				'VALUE' => $value,
			];
			$fieldValidators = $validators[$name] ?? [];
			if (in_array("email", $fieldValidators)) {
				$ret[$name]['ATTRIBUTES'] = [
					'data-validator' => 'email',
				];
			}
			if (in_array("required", $fieldValidators)) {
				$ret[$name]['REQUIRED'] = 'Y';
			}
		}
		return $ret;
	}

    public function getFieldNames()
    {
        if ($this->fieldNames === null) {
            $this->fieldNames = [];
            $class = new \ReflectionClass($this);
            $props = $class->getProperties(\ReflectionProperty::IS_PUBLIC);
            foreach ($props as $prop) {
                $this->fieldNames[] = $prop->getName();
            }
        }
        return $this->fieldNames;
    }

    public function getFieldValues()
    {
        $values = [];
        $names = $this->getFieldNames();
        foreach ($names as $name) {
            $values[$name] = $this->$name;
        }
        return $values;
    }

    public function getFieldValidators()
    {
        return [
            // 'name' => [
            //     'required',
            // ],
            // 'email' => [
            //     'email',
            //     'required',
            //     function($value, $name, $model) {
            //         return true;
            //     }
            // ],
        ];
    }

    public function validate()
    {
        $names = $this->getFieldNames();
        $validators = $this->getFieldValidators();
        foreach ($names as $name) {
            $fieldValidators = $validators[$name] ?? [];
            foreach ($fieldValidators as $validator) {
                $this->validateField($name, $validator);
                if ($this->hasErrors()) {
                    return false;
                }
            }
        }
        return true;
    }

    protected function validateField($name, $validator)
    {
        $value = $this->$name;
        if ($validator === 'required') {
            $this->validateRequired($name, $value);
        }
        else if ($validator === 'email') {
            $this->validateEmail($name, $value);
        }
        else if (is_callable($validator)) {
            $validator($value, $name, $this);
        }
        else {
            throw new \Exception("Указанный валидатор не найден");
        }
    }

    protected function validateRequired($name, $value)
    {
        if (empty($value)) {
            $this->addError($name, "Поле '{$name}' обязательно");
        }
    }

    protected function validateEmail($name, $value)
    {
        if ($value && !check_email($value)) {
            $this->addError($name, "Поле '{$name}' не является email адресом");
        }
    }

    public function hasErrors()
    {
        return ! empty($this->errors);
    }

    protected function addError(string $field, string $error)
    {
        if (isset($this->errors[$field])) {
            $this->errors[$field][] = $error;
        }
        else {
            $this->errors[$field] = [$error];
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
