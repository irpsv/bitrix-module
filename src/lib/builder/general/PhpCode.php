<?php

namespace bitrix_module\builder\general;

class PhpCode
{
	public $code;

	public function __construct(string $code)
	{
		$this->code = $code;
	}
}
