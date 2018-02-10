<?php

namespace module_id\events;

class BaseEventHandler
{
	public static function runStatic()
	{
		$self = new self();
		return $self->run();
	}

	public function run()
	{
		// code
	}
}
