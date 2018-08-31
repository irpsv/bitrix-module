<?php

namespace module_id\agent;

class BaseAgent
{
	public static function runAgent()
	{
		$self = new self();
		$self->run();
		return __METHOD__.'();';
	}

	public function run()
	{
		// code
	}
}
