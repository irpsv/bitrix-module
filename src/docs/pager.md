# Pager

Классы:
- \\bitrix_module\\data\\Pager
- \\bitrix_module\\data\\PagerRequest
- \\bitrix_module\\data\\PagerRequestBuildByComponentParams

Компоненты:
- pager.view

## Примеры

```php
$APPLICATION->IncludeComponent("bitrix_module:pager.view", "", [
   'PAGE_SIZE' => 10,
   'TOTAL_COUNT' => 250,
   // 'PAGES_VIEWED_COUNT' => 5,
]);

$APPLICATION->IncludeComponent("bitrix_module:pager.view", "", [
   'PAGE_SIZE' => 10,
   'TOTAL_COUNT' => 20,
   'REQUEST_NAME' => 'anotherPager',
   'PAGES_VIEWED_COUNT' => 3,
]);

\CModule::includeModule('bitrix_module');

$pager = new \bitrix_module\data\Pager(10, 250);
$pagerRequest = new \bitrix_module\data\PagerRequest($pager);
$pagerRequest->load($_GET);

// дубль первого
$APPLICATION->IncludeComponent("bitrix_module:pager.view", "", [
   'PAGER_REQUEST' => $pagerRequest,
   'PAGES_VIEWED_COUNT' => 9,
]);
```
