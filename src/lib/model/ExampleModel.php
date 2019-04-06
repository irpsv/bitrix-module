<?php

namespace bitrix_module\model;

/**
 * Модель для насыщения сложной бизнес-логикой
 * Использовать в качестве ActiveRecord НЕ рекомендуется - избыточно
 */
class ExampleModel
{
	public $id;
	public $name;
	public $value;

	public static function load($id)
	{
		// загрузка и создание
	}

	public function save()
	{
		// сохранение
	}
}
