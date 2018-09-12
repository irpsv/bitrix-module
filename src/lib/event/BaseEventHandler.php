<?php

namespace bitrix_module\event;

class BaseEventHandler
{
	public static function runStatic(...$args)
	{
		$self = new self(...$args);
		return $self->run();
	}

	public function __construct()
	{

	}

	public function run()
	{
		// code
	}
}
