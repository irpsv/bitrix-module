<?php

namespace module_id\components\classes;

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);

class TestComp extends \CBitrixComponent
{
	public function executeComponent()
	{
		// кеширование
		$cacheTime = $this->arParams['CACHE_TIME'] ?? 3600;
		$cacheAdditionalId = null;
		$cachePath = preg_replace('/[^a-z0-9]/i', '_', __CLASS__);
		if ($this->startResultCache($cacheTime, $cacheAdditionalId, $cachePath)) {
			$this->run();
			$this->endResultCache();
		}
	}

	public function run()
	{
		// получение языковых сообщенте
		$message = \GetMessage('testMessage');
		
		// основная логика работы компонета
		$param1 = $this->arParams['key'];
		$this->arResult['key'] = "значение которое улетит в шаблон";
		$this->includeComponentTemplate();
	}
}
