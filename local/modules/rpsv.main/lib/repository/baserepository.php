<?php

namespace Rpsv\Main\Repository;

use Bitrix\Main\Application;
use Bitrix\Main\ORM\Data\AddResult;
use Bitrix\Main\Result;
use Throwable;

abstract class BaseRepository
{
    public static function getPrimary()
    {
        return 'ID';
    }

    /**
     * Возвращает массив моделей
     *
     * @param $params
     * @return BaseModel[]
     */
    abstract public function getList(array $params): array;

    public function getRow(array $params): ?BaseModel
    {
        $params['limit'] = 1;
        $rows = $this->getList($params);
        return $rows[0] ?? null;
    }

    public function getById($id): ?BaseModel
    {
        $primary = static::getPrimary();
        return $this->getRow([
            'filter' => [
                $primary => $id,
            ],
        ]);
    }

    abstract public function add(array $data): Result;

    abstract public function update($primary, array $data): Result;

    abstract public function createRowByModel(BaseModel $model): array;

    public function save(BaseModel $model): Result
    {
        $row = $this->createRowByModel($model);
        $primary = static::getPrimary();
        if (!property_exists($model, $primary)) {
            $primary = strtolower($primary);
        }

        if ($model->isNewRecord()) {
            $result = $this->add($row);
            if ($result->isSuccess()) {
                if ($result instanceof AddResult) {
                    $model->{$primary} = $result->getId();
                }
                else {
                    $model->{$primary} = $result->getData()['id'];
                }
                $model->notNewRecord();
            }
            return $result;
        }
        else {
            $result = $this->update($model->{$primary}, $row);
        }

        if ($result->isSuccess()) {
            $id = $model->{$primary};
            $cache = new ModelCache(get_class($model));
            $cache->set($id, $model);
        }
        return $result;
    }

    public function transaction(callable $callback)
    {
        $db = Application::getConnection();
        try {
            $db->startTransaction();
            call_user_func($callback);
            $db->commitTransaction();
        }
        catch (Throwable $e) {
            $db->rollbackTransaction();
            throw $e;
        }
    }
}
