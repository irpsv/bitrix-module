<?php

namespace bitrix_module\data;

class Sorter
{
	const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

	protected $fields;
	protected $labels = [];
	protected $activeSort;
	protected $activeColumn;

    public function __construct(array $fields = [])
    {
		$this->fields = [];
		foreach ($fields as $key => $value) {
			if (is_int($key)) {
				$this->addField($value);
			}
			else {
				$this->addField($key);
				$this->setLabel($key, $value);
			}
		}
    }

	public function addField(string $name)
	{
		if (!in_array($name, $this->fields)) {
			$this->fields[] = $name;
			return true;
		}
		return false;
	}

	public function setLabel(string $name, string $label)
	{
		if (in_array($name, $this->fields)) {
			$this->labels[$name] = $label;
		}
	}

	public function getLabels()
	{
		return $this->labels;
	}

	public function setActive(string $name, string $sort)
	{
		if (in_array($name, $this->fields)) {
			$this->activeSort = strtolower($sort) === self::SORT_ASC ? self::SORT_ASC : self::SORT_DESC;
			$this->activeColumn = $name;
			return true;
		}
		return false;
	}

	public function getFields()
	{
		return $this->fields;
	}

	public function getActive()
	{
		if ($this->activeColumn) {
			return [
				$this->activeColumn => $this->activeSort
			];
		}
		return [];
	}
}
