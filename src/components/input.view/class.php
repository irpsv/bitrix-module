<?php

namespace bitrix_module\components\classes;

use bitrix_module\form\Field;

class InputView extends \CBitrixComponent
{
	public function executeComponent()
    {
        $cacheTime = $this->arParams['CACHE_TIME'] ?? 86400000;
		$cachePath = preg_replace('/[^a-z0-9]/i', '_', get_class($this));
        $cacheAdditionalId = null;

        if ($this->startResultCache($cacheTime, $cacheAdditionalId, $cachePath)) {
            $this->run();
            $this->endResultCache();
        }
    }

	public function run()
	{
		\CModule::includeModule('bitrix.module');

		$field = $this->arParams['MODEL'] ?? null;
		if ($field) {
			if (($field instanceof Field) === false) {
				throw new \Exception("Параметр 'MODEL' должен реализовывать класс ".Field::class);
			}
		}
		else {
			$field = new Field($this->arParams);
		}

		$this->arResult['FIELD'] = $field->toArray();
		$this->arResult['FIELD']['IS_ASSOC_VALUES'] = $field->isAssocArrayValues();
		$this->includeComponentTemplate();
	}
}
