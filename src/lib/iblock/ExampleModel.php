<?php

namespace module_id\model;

use module_id\iblock\ElementActiveRecord;

class ExampleModel extends ElementActiveRecord
{
	public $managerId;
	public $usersIds;

	public static function getIblockCode()
	{
		return 'managers_to_user';
	}

	public static function getSchema()
	{
		return [
			'usersIds' => 'PROPERTY_users',
			'managerId' => 'PROPERTY_manager',
		];
	}

	public static function getModelName($model)
	{
		return "Привязка пользователей к менеджеру '{$model->managerId}'";
	}
}
