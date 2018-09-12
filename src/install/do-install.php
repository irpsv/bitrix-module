<?php

namespace bitrix_module\install;

include_once __DIR__.'/ModuleIblockBuilder.php';

class Test extends \ModuleIblockBuilder
{
	/**
	 * https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblocktype/add.php
	 */
	public function getType()
	{
		return [
			'ID' => 'type',
			'SECTIONS' => 'Y',
			'IN_RSS' => 'N',
			'SORT' => '500',
			'LANG' => [
				'ru' => [
					'NAME' => 'Название',
					'SECTION_NAME' => 'Разделы',
					'ELEMENT_NAME' => 'Элементы',
				],
			],
		];
	}

	/**
	 * https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblock/add.php
	 * Подставляются автоматически:
	 * LID
	 * IBLOCK_TYPE_ID
	 */
	public function getIblock()
	{
		return [
			'NAME' => 'Название',
			'CODE' => 'Символьный код', // обязательно
			'BIZPROC' => 'N',
			'WORKFLOW' => 'N',
		];
	}

	/**
	 * https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblockproperty/add.php
	 * Подставляются автоматически:
	 * IBLOCK_ID
	 */
	public function getProperties()
	{
		return [
			[
				'NAME' => 'Название',
				'CODE' => 'property_code_1', // обязательно
				'PROPERTY_TYPE' => 'S',
				// 'PROPERTY_TYPE' => 'N',
				// 'PROPERTY_TYPE' => 'F',
				// 'PROPERTY_TYPE' => 'E',
				// 'PROPERTY_TYPE' => 'G',
			],
			[
				'NAME' => 'Название',
				'CODE' => 'property_code_2', // обязательно
				'PROPERTY_TYPE' => 'L',
				'VALUES' => [
					[
						'VALUE' => 'Значение списочного свойства 1',
					],
					[
						'VALUE' => 'Значение списочного свойства 2',
						'SORT' => 100,
						'DEF' => 'Y',
					],
				],
			],
		];
	}

	/**
	 * https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblocksection/add.php
	 * Подставляются автоматически:
	 * IBLOCK_ID
	 */
	public function getSections()
	{
		return [
			[
				'NAME' => 'Название категории 1',
			],
			[
				'NAME' => 'Название категории 2',
				'CHILDRENS' => [
					[
						'NAME' => 'Название дочерней категории 1',
						'CODE' => 'Символьный код',
					],
					[
						'NAME' => 'Название дочерней категории 2',
						'CHILDRENS' => [
							[
								'NAME' => 'Название дочерней дочки категории',
							],
						],
					],
				],
			],
		];
	}

	/**
	 * https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblockelement/add.php
	 * Подставляются автоматически:
	 * IBLOCK_ID
	 */
	public function getElements()
	{
		return [
			[
				'NAME' => 'Название',
				'PROPERTY_VALUES' => [
					'property_code_1' => 'Значение',
					'property_code_2' => $this->getPropertyValueIdByValue("property_code_2", "Значение списочного свойства 1"), // для списочных
				],
			],
			[
				'NAME' => 'Название',
				'IBLOCK_SECTION_ID' => $this->getSectionIdByName("Название категории 1"),
				'SECTIONS' => [
					"Название категории 1",
					"Название категории 2",
					"Название дочерней дочки категории",
				],
			],
		];
	}
}

(new Test)->create();
