<?php

namespace Rpsv\Main\Repository;

use _CIBElement;
use CIBlockElement;
use Bitrix\Main\Loader;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\PropertyEnumerationTable;
use ReflectionClass;

abstract class IblockElementRepository extends BaseRepository
{
    public function __construct()
    {
        Loader::includeModule('iblock');
    }

    /**
     * ИД инфоблока
     *
     * @return integer
     */
    abstract public static function getIblockId(): int;

    /**
     * Полный путь класса BaseModel
     *
     * @return string
     */
    abstract public static function getModelClassName(): string;

    /**
     * Соотстветсвие полей модели и строки базы. Пример:
     *  return [
     *      'name' => 'NAME',
     *      'userId' => 'PROPERTY_USER_ID',
     *      'timestamp' => 'DATE_CREATE',
     *  ]
     *
     * @return array
     */
    abstract public static function getFieldNamesModel2Row(): array;

    public function createModelByElement(_CIBElement $element): BaseModel
    {
        $props = $element->GetProperties();
        $fields = $element->getFields();

        $re = '/^PROPERTY_(.+)$/i';
        $ref = new ReflectionClass(static::getModelClassName());
        $model = $ref->newInstance();
        $model2row = static::getFieldNamesModel2Row();
        foreach ($model2row as $keyModel => $keyRow) {
            if (preg_match($re, $keyRow, $m)) {
                $propCode = $m[1];
                if (isset($props[$propCode])) {
                    $model->{$keyModel} = $props[$propCode]['~VALUE'];
                }
            }
            else {
                $model->{$keyModel} = $fields[$keyRow];
            }
        }
        $this->prepareModelAfterCreate($model, $fields, $props);
        return $model;
    }

    public function prepareModelAfterCreate(BaseModel $model, $fields, $props)
    {
        // pass
    }

    public function createRowByModel(BaseModel $model): array
    {
        $re = '/^PROPERTY_(.+)$/i';
        $row = [
            'PROPERTY_VALUES' => [],
        ];
        $pictureFields = [
            'PREVIEW_PICTURE',
            'DETAIL_PICTURE',
        ];
        $model2row = static::getFieldNamesModel2Row();
        foreach ($model2row as $keyModel => $keyRow) {
            if (preg_match($re, $keyRow, $m)) {
                $propCode = $m[1];
                $row['PROPERTY_VALUES'][$propCode] = $model->{$keyModel};
            }
            else {
                // пропускаем поля изображений, если указан идентификатор (значит они не изменились)
                if (in_array($keyRow, $pictureFields)) {
                    if (is_numeric($model->{$keyModel})) {
                        continue;
                    }
                }
                $row[$keyRow] = $model->{$keyModel};
            }
        }
        $this->prepareRowBeforeSave($row, $model);
        return $row;
    }

    public function prepareRowBeforeSave(array & $row, BaseModel $model)
    {
        // pass
    }

    public function getDefaultName(array $row)
    {
        return '-';
    }

    public function getDefaultFilter(): array
    {
        return [
            'IBLOCK_ID' => static::getIblockId(),
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
        ];
    }

    public function getDefaultOrder(): array
    {
        return [
            'SORT' => 'ASC',
            'ID' => 'ASC',
        ];
    }

    public function getCount(array $params): int
    {
        $filter = array_merge(
            $this->getDefaultFilter(),
            $params['filter'] ?? []
        );
        return (int) CIBlockElement::GetList([], $filter, []);
    }

    public function getList(array $params): array
    {
        $filter = array_merge(
            $this->getDefaultFilter(),
            $params['filter'] ?? []
        );
        $order = $params['order'] ?? $this->getDefaultOrder();

        if ($params['offset'] && $params['limit']) {
            $nav = [
                'iNumPage' => 2,
                'nPageSize' => $params['offset'],
                'nTopCount' => $params['limit'],
            ];
        }
        else if ($params['limit']) {
            $nav = [
                'nTopCount' => $params['limit'],
            ];
        }
        else {
            $nav = false;
        }

        $items = [];
        $cache = new ModelCache($this->getModelClassName());
        $result = CIBlockElement::getList($order, $filter, false, $nav, ['ID']);
        while ($row = $result->fetch()) {
            $id = $row['ID'];
            $model = $cache->get($id);
            if (!$model) {
                $element = CIBlockElement::GetByID($id)->GetNextElement(true, true);
                $model = $this->createModelByElement($element);
                $model->notNewRecord();
                $cache->set($id, $model);
            }
            $items[] = $model;
        }
        return $items;
    }

    public function prepareSaveParams(array $params): array
    {
        $params['IBLOCK_ID'] = static::getIblockId();
        if (!isset($params['NAME'])) {
            $params['NAME'] = $this->getDefaultName($params);
        }
        return $params;
    }

    public function add(array $params): Result
    {
        $params = $this->prepareSaveParams($params);
        $result = new Result();
        $ibe = new CIBlockElement;
        $id = $ibe->Add($params);
        if ($ibe->LAST_ERROR) {
            $result->addError(
                new Error($ibe->LAST_ERROR)
            );
        }
        else {
            $result->setData([
                'id' => $id,
            ]);
        }
        return $result;
    }

    public function update($id, array $params): Result
    {
        $params = $this->prepareSaveParams($params);
        $result = new Result();
        $properties = $params['PROPERTY_VALUES'] ?? null;
        unset($params['PROPERTY_VALUES']);

        if ($params) {
            $ibe = new CIBlockElement;
            $ibe->Update($id, $params);
            if ($ibe->LAST_ERROR) {
                $result->addError(
                    new Error($ibe->LAST_ERROR)
                );
            }
        }
        if ($result->isSuccess() && $properties) {
            CIBlockElement::SetPropertyValuesEx($id, static::getIblockId(), $properties);
        }
        return $result;
    }

    public function getListProperty(array $params)
    {
        $params['filter'] = array_merge(
            $params['filter'] ?? [],
            [
                'IBLOCK_ID' => static::getIblockId(),
            ]
        );
        return PropertyTable::getList($params);
    }

    public function getListPropertyValue(array $params)
    {
        $params['filter'] = array_merge(
            $params['filter'] ?? [],
            [
                'PROPERTY.IBLOCK_ID' => static::getIblockId(),
            ]
        );
        return PropertyEnumerationTable::getList($params);
    }

    /**
     * Получить значение свойства по указанному полю
     *
     * @param string $propertyCode
     * @param string $fieldName
     * @param [type] $value
     * @return void
     */
    public function getPropertyValueBy(string $propertyCode, string $fieldName, $value): array
    {
        $row = $this->getListPropertyValue([
            'filter' => [
                'PROPERTY.CODE' => $propertyCode,
                $fieldName => $value,
            ],
        ])->fetch();
        return $row ?: [];
    }
}
