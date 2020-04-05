<?php

namespace Rpsv\Main\Repository;

use Bitrix\Main\Application;
use Exception;

/**
 * Кеш моделей
 */
class ModelCache
{
	const CACHE_DIR = 'models';
	const DEFAULT_TTL = 36000000;

	protected $classModel;

	public function __construct(string $classModel)
	{
		$this->classModel = $classModel;
    }

    /**
     * Ключ кеша для модели
     *
     * @param mixed $id
     * @return string
     */
    public function getModelKey($id): string
    {
        return $this->classModel . $id;
    }

    /**
     * Директория кеша для модели
     *
     * @return string
     */
    public function getModelDir(): string
    {
        return self::CACHE_DIR .'/'. preg_replace('/[^a-z0-9]/i', '-', $this->classModel);
    }

    /**
     * Добавить значение модели (либо обнулить)
     *
     * @param string $id
     * @param BaseModel|null $model
     * @return void
     */
	public function set(string $id, ?BaseModel $model)
	{
        $cache = Application::getInstance()->getCache();
        $cache->forceRewriting(true);

        if ($cache->startDataCache(self::DEFAULT_TTL, $this->getModelKey($id), $this->getModelDir())) {
            $result = [
                'model' => $model,
            ];
            $cache->endDataCache($result);
        }
        else {
            throw new Exception("Cache is not created");
        }
	}

    /**
     * Получить модель из кеша
     *
     * @param string $id
     * @return BaseModel|null
     */
	public function get(string $id): ?BaseModel
	{
        $cache = Application::getInstance()->getCache();

        if ($cache->initCache(self::DEFAULT_TTL, $this->getModelKey($id), $this->getModelDir())) {
            return $cache->getVars()['model'] ?? null;
        }
        return null;
	}

    /**
     * Удалить (обнулить) из кеша запись
     *
     * @param string $id
     * @return void
     */
	public function delete(string $id)
	{
		$this->set($id, null);
	}

    /**
     * Очистить кеш модели (удалить все записи кеша)
     *
     * @return void
     */
	public function clear()
	{
        $cache = Application::getInstance()->getCache();
        $cache::clearCache(true, $this->getModelDir());
    }

    /**
     * Обновление кеша при сохранении элемента
     * Для событий:
     * - OnAfterIBlockUpdate
     * - OnAfterIBlockAdd
     *
     * @param array $fields
     * @return void
     */
    public static function onAfterSaveIblockElement($fields)
    {
        $id = $fields['ID'];
        if (!$id || !$fields['RESULT']) {
            return;
        }

        $iblockId = $fields['IBLOCK_ID'];
        if (!$iblockId) {
            return;
        }

        // if ($iblockId == 123) {
        //     (new ModelCache(UserModel::class))->delete($id);
        //     (new UserRepository)->getById($id);
        // }
    }
}
