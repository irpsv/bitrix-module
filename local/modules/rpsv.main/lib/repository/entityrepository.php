<?php

namespace Rpsv\Main\Repository;

use Bitrix\Main\Result;
use ReflectionClass;

abstract class EntityRepository extends BaseRepository
{
    /**
     * Полный путь класса DataManager
     *
     * @return string
     */
    abstract public static function getEntityClassName(): string;

    /**
     * Полный путь класса BaseModel
     *
     * @return string
     */
    abstract public static function getModelClassName(): string;

    /**
     * Соотстветсвие полей модели и строки базы. Пример:
     *  return [
     *      'userId' => 'user_id',
     *      'timestamp' => 'date_create',
     *  ]
     *
     * @return array
     */
    abstract public static function getFieldNamesModel2Row(): array;

    public function createModelByRow(array $row): BaseModel
    {
        $ret = new ReflectionClass(static::getModelClassName());
        $model = $ret->newInstance();
        $model2row = static::getFieldNamesModel2Row();
        foreach ($model2row as $keyModel => $keyRow) {
            $model->{$keyModel} = $row[$keyRow];
        }
        return $model;
    }

    public function createRowByModel(BaseModel $model): array
    {
        $row = [];
        $model2row = static::getFieldNamesModel2Row();
        foreach ($model2row as $keyModel => $keyRow) {
            $row[$keyRow] = $model->{$keyModel};
        }
        return $row;
    }

    public function getList(array $params): array
    {
        $primary = static::getPrimary();
        $cache = new ModelCache($this->getModelClassName());
        $params['select'] = [ $primary ];

        $className = static::getEntityClassName();
        $result = $className::getList($params);
        $items = [];
        while ($row = $result->fetch()) {
            $id = $row[$primary];
            $model = $cache->get($id);
            if (!$model) {
                $row = $className::getRow([
                    'filter' => [
                        $primary => $id,
                    ],
                ]);
                $model = $this->createModelByRow($row);
                $model->notNewRecord();
                $cache->set($id, $model);
            }
            $items[] = $model;
        }
        return $items;
    }

    public function add(array $params): Result
    {
        $className = static::getEntityClassName();
        return $className::add($params);
    }

    public function update($id, array $params): Result
    {
        $className = static::getEntityClassName();
        return $className::update($id, $params);
    }
}
