<?php

namespace bitrix_module\iblock;

\CModule::includeModule('iblock');

abstract class ElementActiveRecord
{
	private static $iblockId;
	public $id;

	abstract public static function getIblockCode();

	abstract public static function getSchema();

	public static function getModelName($model)
	{
		return $model->name ?? null;
	}

	public static function getIblockId()
	{
		if (!self::$iblockId) {
			$code = static::getIblockCode();
			$order = [
				'SORT' => 'asc',
				'ID' => 'desc',
			];
			$filter = [
				'CODE' => $code,
				'ACTIVE' => 'Y',
				'CHECK_PERMISSIONS' => 'N',
			];
			$iblock = \CIBlock::getList($order, $filter)->fetch();
			if (!$iblock) {
				throw new \Exception("Не найден инфоблок с символьным кодом '{$code}', либо он неактивен");
			}
			return $iblock['ID'];
		}
		return self::$iblockId;
	}

	public static function getDefaultFilter()
	{
		return [
			'ACTIVE' => 'Y',
			'IBLOCK_ID' => static::getIblockId(),
			'CHECK_PERMISSIONS' => 'N',
		];
	}

	public static function getMergedDefaultFilter(array $filter)
	{
		return array_merge(
			static::getDefaultFilter(),
			$filter
		);
	}

	public static function getList($order = null, $filter = null, $group = false, $nav = false, $select = [])
	{
		if (!$order) {
			$order = [
				'SORT' => 'asc',
			];
		}
		if (!$filter) {
			$filter = static::getDefaultFilter();
		}
		else {
			$filter['IBLOCK_ID'] = static::getIblockId();
		}
		return \CIBlockElement::getList($order, $filter, $group, $nav, $select);
	}

	public static function getById($id)
	{
		$filter = static::getDefaultFilter();
		$filter['ID'] = $id;
		return static::getModel(null, $filter);
	}

	public static function getModel($order = null, $filter = null, $group = false, $nav = false, $select = [])
	{
		$element = static::getList($order, $filter, $group, $nav, $select)->getNextElement();
		if (!$element) {
			return null;
		}
		return static::create($element);
	}

	public static function getModels($order = null, $filter = null, $group = false, $nav = false, $select = [])
	{
		$ret = [];
		$result = static::getList($order, $filter, $group, $nav, $select);
		while ($element = $result->getNextElement()) {
			$ret[] = static::create($element);
		}
		return $ret;
	}

	public static function create(\_CIBElement $element)
	{
		$model = new static();
		$model->id = (int) $element->getFields()['ID'];

		$schema = static::getSchema();
		foreach ($schema as $modelProperty => $elementField) {
			if (stripos($elementField, 'PROPERTY_') === 0) {
				$propertyName = substr($elementField, 9);
				$model->$modelProperty = $element->getProperty($propertyName)['VALUE'] ?: null;
			}
			else {
				$model->$modelProperty = $element->getFields()[$elementField] ?: null;
			}
		}
		return $model;
	}

	public function beforeSave()
	{

	}

	public function save()
	{
		return static::saveModel($this);
	}

	public function afterSave()
	{

	}

	public function beforeDelete()
	{

	}

	public function delete()
	{
		return static::deleteModel($this);
	}

	public function afterDelete()
	{

	}

	public static function saveModel($model)
	{
		$class = get_called_class();
		if (($model instanceof $class) === false) {
			throw new \Exception("Сохраняемый объект, должен реализовывать вызываемый класс");
		}

		$model->beforeSave();

		$ibe = new \CIBlockElement;
		$fields = [
			'NAME' => static::getModelName($model),
			'IBLOCK_ID' => static::getIblockId(),
			'PROPERTY_VALUES' => [],
		];
		$schema = static::getSchema();
		foreach ($schema as $modelProperty => $elementField) {
			if (stripos($elementField, 'PROPERTY_') === 0) {
				$propertyName = substr($elementField, 9);
				$fields['PROPERTY_VALUES'][$propertyName] = $model->$modelProperty;
			}
			else {
				$fields[$elementField] = $model->$modelProperty;
			}
		}

		if ($model->id) {
			$ibe->Update($model->id, $fields);
		}
		else {
			$model->id = (int) $ibe->Add($fields);
		}

		if ($ibe->LAST_ERROR) {
			throw new \Exception($ibe->LAST_ERROR);
		}
		else {
			$model->afterSave();
		}
		return $model->id;
	}

	public static function deleteModel($model)
	{
		$class = get_called_class();
		if (($model instanceof $class) === false) {
			throw new \Exception("Сохраняемый объект, должен реализовывать вызываемый класс");
		}

		if ($model->id) {
			$model->beforeDelete();
			$ret = \CIBlockElement::delete($model->id);
			$model->afterDelete();
			return $ret;
		}
		else {
			return false;
		}
	}
	
	public function getRow()
	{
		if ($this->id) {
			return \CIBlockElement::getById($this->id)->fetch();
		}
		return null;
	}

	public function getDetailUrl()
	{
		$row = $this->getRow();
		return \CIBlock::replaceDetailUrl(
			$row['DETAIL_PAGE_URL'],
			$row,
			false,
			'E'
		);
	}
}
