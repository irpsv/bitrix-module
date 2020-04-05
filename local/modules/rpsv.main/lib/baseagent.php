<?php

namespace Rpsv\Main;

abstract class BaseAgent
{
	public static function runAgent()
	{
		$self = new self();
		$self->run();
		return __METHOD__.'();';
	}

	abstract public function run();
}
