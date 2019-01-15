<?php

namespace bitrix_module\builder\general;

class PrepareFieldsByMap
{
    protected $fields;
    protected $mapFields;

    public static function runStatic(...$args)
    {
        $self = new self(...$args);
        return $self->run();
    }

    public function __construct(array $fields, array $mapFields)
    {
        $this->fields = $fields;
        $this->mapFields = $mapFields;
    }

    public function run()
    {
        foreach ($this->fields as $key => & $value) {
            $mapField = $this->mapFields[$key] ?? null;
            $value = $this->getFieldValueByMap($value, $mapField);
        }
        return $this->fields;
    }

    public function getFieldValueByMap($value, $mapField)
    {
        if (!is_array($mapField)) {
            $tmp = [
                'name' => $mapField->getColumnName(),
                'default' => $mapField->getDefaultValue(),
                'default_value' => $mapField->getDefaultValue(),
            ];

            $dataType = null;
            if ($mapField instanceof \Bitrix\Main\ORM\Fields\DatetimeField) {
                $dataType = "datetime";
            }
            else if ($mapField instanceof \Bitrix\Main\ORM\Fields\IntegerField) {
                $dataType = "integer";
            }
            else if ($mapField instanceof \Bitrix\Main\ORM\Fields\StringField) {
                $dataType = "string";
            }
            else if ($mapField instanceof \Bitrix\Main\ORM\Fields\BooleanField) {
                $dataType = "boolean";
            }
            else if ($mapField instanceof \Bitrix\Main\ORM\Fields\EnumField) {
                $dataType = "enum";
                $tmp['values'] = $mapField->getValues();
            }
            else {
                echo '<pre>';
                var_dump(
                    __LINE__,
                    $mapField
                );
                echo '</pre>';
                die();
            }

            $tmp['data_type'] = $dataType;
            $mapField = $tmp;
            unset($tmp);
        }

        $defaultValue = $mapField['default_value'] ?? $mapField['default'] ?? null;
        if ($value instanceof \bitrix_module\builder\general\PhpCode) {
            return $value;
        }
        else if ($mapField['data_type'] === 'string') {
            return $value ? "{$value}" : $defaultValue;
        }
        else if ($mapField['data_type'] === 'boolean') {
            if ($value === 'Y') {
                return 'Y';
            }
            else if (!$value) {
                return $defaultValue;
            }
            else {
                return 'N';
            }
        }
        else if ($mapField['data_type'] === 'datetime') {
            if ($value) {
                $strValue = (string) $value;
                return new \bitrix_module\builder\general\PhpCode("new \Bitrix\Main\Type\Date('{$strValue}')");
            }
            else {
                return $defaultValue;
            }
        }
        else if ($mapField['data_type'] === 'integer') {
            if ($value || $value === '0') {
                return (int) $value;
            }
            else {
                return $defaultValue;
            }
        }
        else if ($mapField['data_type'] === 'enum') {
            $enumValues = $mapField['values'];
            foreach ($enumValues as $enumValue) {
                $isExists = false;
                if (is_int($enumValue)) {
                    $value = intval($value);
                    $isExists = $value === $enumValue;
                }
                else {
                    $value = strval($value);
                    $isExists = $value === strval($enumValue);
                }
                if ($isExists) {
                    return $value;
                }
            }
            return $defaultValue;
        }
        else {
            echo '<pre>';
            var_dump(
                $value, $mapField
            );
            echo '</pre>';
            die();
        }
    }
}
