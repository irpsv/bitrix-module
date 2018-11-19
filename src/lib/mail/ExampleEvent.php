<?php

namespace bitrix_module\mail;

class ExampleEvent extends BaseEvent
{
	public function getEventName()
    {
        return "EXAMPLE_EVENT_NAME";
    }
}
