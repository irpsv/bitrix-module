<?php

namespace module_id\agents;

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
