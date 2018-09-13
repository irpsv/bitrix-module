<?php

namespace bitrix_module\mail;

abstract class BaseEvent
{
	protected $params;

	public static function send(array $params = [])
	{
		$self = new self($params);
		$self->run();
	}

	public function __construct(array $params = [])
	{
		$this->params = $params;
	}

	public function getSiteId()
	{
		$siteId = \Bitrix\Main\Context::getCurrent()->getSite();
		if (!$siteId) {
			$site = \Bitrix\Main\SiteTable::getRow([
				'select' => [
					'ID'
				],
				'filter' => [
					'=DEF' => 'Y',
				],
			]);
			return $site['ID'];
		}
		return $siteId;
	}

	abstract public function getEventName();

	public function getDefaultParams()
	{
		return [];
	}

	public function run()
	{
		$params = array_merge(
			$this->getDefaultParams() ?: [],
			$this->params ?: []
		);
		$result = \Bitrix\Main\Main\Event::send([
			'EVENT_NAME' => $this->getEventName(),
			'LID' => $this->getSiteId(),
			'C_FIELDS' => $params,
		]);
		if ($result->isSuccess()) {
			return true;
		}
		else {
			$messages = $result->getErrorMessages();
			$this->addLog(
				join(";\n", $messages)
			);
			return false;
		}
	}

	public function addLog(string $message)
	{
		\CEventLog::Add([
			'SEVERITY' => 'ERROR',
			'AUDIT_TYPE_ID' => __CLASS__,
			'MODULE_ID' => 'olof_bonuses',
			'DESCRIPTION' => $message,
		]);
	}
}
