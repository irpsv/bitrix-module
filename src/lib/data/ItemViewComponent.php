<?php

namespace bitrix_module\data;

/******
Параметры компонента:

$arComponentParameters = [
    'PARAMETERS' => [
        'PROCESS_404' => [
            'NAME' => 'Вызывать 404 ошибку при пустом результате',
            'PARENT' => 'BASE',
            'TYPE' => 'CHECKBOX',
        ],
        'ID' => [
            'NAME' => 'Идентификатор элемента',
            'PARENT' => 'DATA_SOURCE',
            'TYPE' => 'STRING',
        ],
        'FILTER' => [
            'NAME' => 'Значения фильтра (массив)',
            'PARENT' => 'DATA_SOURCE',
            'TYPE' => 'STRING',
        ],
    ],
];

******/

abstract class ItemViewComponent extends \CBitrixComponent
{
    abstract public function getModelByFilter(array $filter);

    abstract public function getLastUpdate(array $filter);

    public function getCacheLastUpdate($cacheTime, $cacheAdditionalId, $cachePath)
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cacheId = $this->getCacheID($cacheAdditionalId).'_lastUpdate';
		if ($cache->initCache($cacheTime, $cacheId, $cachePath)) {
			$vars = $cache->getVars();
			return $vars['lastUpdate'] ?? null;
		}
		return null;
	}

	public function setCacheLastUpdate($cacheTime, $cacheAdditionalId, $cachePath, $value)
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cacheId = $this->getCacheID($cacheAdditionalId).'_lastUpdate';
		$cache->clean($cacheId, $cachePath);
		$cache->startDataCache($cacheTime, $cacheId, $cachePath, [
			'lastUpdate' => $value,
		]);
		$cache->endDataCache();
	}

    public function executeComponent()
    {
		\CModule::includeModule('iblock');
		
        $cacheTime = $this->arParams['CACHE_TIME'] ?? 360000000;
        $cacheAdditionalId = null;
        $cachePath = preg_replace('/[^a-z0-9]/i', '_', get_class($this));

        $filter = $this->getFilter();
        $realLastUpdate = $this->getLastUpdate($filter);
        $cacheLastUpdate = $this->getCacheLastUpdate($cacheTime, $cacheAdditionalId, $cachePath);
        if ($realLastUpdate !== $cacheLastUpdate) {
            $this->clearResultCache($cacheAdditionalId, $cachePath);
        }

        if ($this->startResultCache($cacheTime, $cacheAdditionalId, $cachePath)) {
            $this->run();
            $this->endResultCache();
            $this->setCacheLastUpdate($cacheTime, $cacheAdditionalId, $cachePath, $realLastUpdate);
        }
    }

    public function getFilter()
    {
        $id = $this->arParams['ID'] ?? null;
		$filter = $this->arParams['FILTER'] ?? null;

        if ($id) {
			$filter = [
				'ID' => $id,
			];
		}
		return $filter;
    }

    public function run()
	{
        $filter = $this->getFilter();
        if ($filter) {
            $row = $this->getModelByFilter($filter);
        }
		else {
			throw new \Exception("Должен быть заполнен один из параметров: 'ID' или 'FILTER'");
		}

		if (!$row && $this->arParams['PROCESS_404']) {
			include $_SERVER['DOCUMENT_ROOT'].'/404.php';
			die();
		}

		$this->arResult['ROW'] = $row;
		$this->includeComponentTemplate();
	}
}
