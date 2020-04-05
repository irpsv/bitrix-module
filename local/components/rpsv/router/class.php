<?php

namespace Rpsv;

use CBitrixComponent;
use CComponentEngine;
use Bitrix\Main\Application;

class Router extends CBitrixComponent
{
    protected static $currentFolder;
    protected static $currentUrlTemplates;

    public function executeComponent()
    {
        $vars = [];
        static::$currentFolder = $folder = (string) $this->arParams['SEF_FOLDER'];
        static::$currentUrlTemplates = $templates = (array) $this->arParams['SEF_URL_TEMPLATES'];

        $page = CComponentEngine::ParseComponentPath($folder, $templates, $vars);
        if ($page) {
            $this->arResult['PAGE'] = $page;
            $this->arResult['VARS'] = $vars;
            $this->includeComponentTemplate($page);
        }
        else {
            $this->process404();
        }
    }

    public function process404()
    {
        if (isset($this->arParams['FILE_404']) && file_exists($this->arParams['FILE_404'])) {
            include $this->arParams['FILE_404'];
            die();
        }

        $path = $_SERVER['DOCUMENT_ROOT'].'/404.php';
        if (file_exists($path)) {
            include $path;
            die();
        }

        echo "404";
    }

    public static function getUrl(string $routeName, array $params = []): string
    {
        $baseUrl = static::$currentFolder;
        $needPath = static::$currentUrlTemplates[$routeName] ?? null;
        if ($needPath) {
            $needPath = $baseUrl . $needPath;
        }
        else {
            $needPath = static::getGlobalRules()[$routeName] ?? null;
            if (!$needPath) {
                return $baseUrl;
            }
        }

        if ($params) {
            $needPath = str_replace(
                array_keys($params),
                array_values($params),
                $needPath
            );
        }
        return $needPath;
    }

    public function sendJsonResponse($data)
    {
        global $APPLICATION;

        $APPLICATION->RestartBuffer();
        header("Content-type:application/json");

        echo json_encode($data);
        die();
    }

    public function getRequest()
    {
        return Application::getInstance()->getContext()->getRequest();
    }

    public function isAjaxRequest()
    {
        return $this->getRequest()->isAjaxRequest();
    }

    /**
     * Глобальные правила, которые используеются в нескольких шаблонах
     * ИСПОЛЬЗУЮТСЯ ТОЛЬКО ДЛЯ ПОСТРОЕНИЯ ССЫЛОК в методе getUrl
     *
     * @return array
     */
    public static function getGlobalRules(): array
    {
        // указываются сразу с baseUrl (полный адрес вместе с корнем)
        return [
            
        ];
    }
}
