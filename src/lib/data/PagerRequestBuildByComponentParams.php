<?php

namespace bitrix_module\data;

class PagerRequestBuildByComponentParams
{
	protected $arParams;

	public static function runStatic(array $arParams)
	{
		$self = new self($arParams);
		return $self->run();
	}

	public function __construct(array $arParams)
	{
		$this->arParams = $arParams;
	}

	public function run()
	{
		$pagerRequest = $this->arParams['PAGER_REQUEST'] ?? null;
		if ($pagerRequest instanceof PagerRequest) {
			return $pagerRequest;
		}
		else if ($pagerRequest) {
			throw new \Exception("Параметр 'PAGER_REQUEST' должен реализовывать класс ". PagerRequest::class);
		}
		else {
			// pass
		}

		if (!array_key_exists('TOTAL_COUNT', $this->arParams)) {
			throw new \Exception("Параметр 'TOTAL_COUNT' обязателен");
		}

		$pageNow = (int) ($this->arParams['PAGE_NOW'] ?? 0);
		$pageSize = (int) ($this->arParams['PAGE_SIZE'] ?? 0);
		$totalCount = (int) ($this->arParams['TOTAL_COUNT']);
		$requestName = (string) ($this->arParams['REQUEST_NAME'] ?? 'p');

		if (!$pageSize) {
			throw new \Exception("Параметр 'PAGE_SIZE' обязателен");
		}

		$pager = new Pager($pageSize, $totalCount, $pageNow);
		$pagerRequest = new PagerRequest($pager, $requestName);
		$pagerRequest->isOnlyData = isset($this->arParams['ONLY_DATA']) && $this->arParams['ONLY_DATA'] !== 'N';

		return $pagerRequest;
	}
}
