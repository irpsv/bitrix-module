<?php

namespace bitrix_module\builder\general;

abstract class BaseMapperBuilder
{
	public function getCreateCodeByMapper($className, $fields, $outputVar = null)
	{
		$fieldsStr = $this->arrayToStr($fields, 0);
		if ($outputVar) {
			return trim("
\$fields = {$fieldsStr};
\$result = {$className}::add(\$fields);
if (\$result->isSuccess()) {
	{$outputVar} = \$result->getId();
}
else {
	\$message = join('\\n', \$result->getErrorMessages());
	throw new \\Exception(\$message);
}
			");
		}
		else {
			return trim("
\$fields = {$fieldsStr};
\$result = {$className}::add(\$fields);
if (!\$result->isSuccess()) {
	\$message = join('\\n', \$result->getErrorMessages());
	throw new \\Exception(\$message);
}
			");
		}
	}

	public function getCreateCodeByOldClass($className, $fields, $outputVar = null)
	{
		$fieldsStr = $this->arrayToStr($fields, 0);
		if ($outputVar) {
			return trim("
\$model = new {$className};
{$outputVar} = \$model->add({$fieldsStr});
if (\$model->LAST_ERROR) {
	throw new \\Exception(\$model->LAST_ERROR);
}
			");
		}
		else {
			return trim("
\$model = new {$className};
\$model->add({$fieldsStr});
if (\$model->LAST_ERROR) {
	throw new \\Exception(\$model->LAST_ERROR);
}
			");
		}
	}

	public function arrayToStr(array $fields, int $countTabs = 0)
	{
		$code = "[\n";
		$countTabs++;
		foreach ($fields as $key => $value) {
			$code .= str_repeat("\t", $countTabs);
			if (is_array($value)) {
				$value = $this->arrayToStr($value, $countTabs);
				$code .= "'{$key}' => {$value},";
			}
			else if ($value instanceof \bitrix_module\builder\general\PhpCode) {
				$code .= "'{$key}' => {$value->code},";
			}
			else if (is_null($value)) {
				$code .= "'{$key}' => NULL,";
			}
			else if (is_bool($value)) {
				$value = $value ? 'true' : 'false';
				$code .= "'{$key}' => {$value},";
			}
			else if (is_int($value) || is_float($value)) {
				$code .= "'{$key}' => {$value},";
			}
			else {
				$value = str_replace("'", "\'", strval($value));
				$code .= "'{$key}' => '{$value}',";
			}
			$code .= "\n";
		}
		$countTabs--;
		$code .= str_repeat("\t", $countTabs) ."]";
		return $code;
	}
}
