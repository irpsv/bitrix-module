<?php

namespace Rpsv\Main\Repository;

use ArrayAccess;
use Exception;
use ReflectionProperty;

abstract class BaseModel implements ArrayAccess
{
    protected $isNewRecord = true;

    public function notNewRecord(): void
    {
        $this->isNewRecord = false;
    }

    public function isNewRecord(): bool
    {
        return $this->isNewRecord;
    }

    public function toArray(): array
    {
        return (array) $this;
    }

    //
    // ArrayAccess
    //

    public function offsetExists($offset)
    {
        if (property_exists($this, $offset)) {
            $ref = new ReflectionProperty($this, $offset);
            return $ref->isPublic();
        }
        return false;
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->{$offset};
        }
        return null;
    }

    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            $this->{$offset} = $value;
        }
    }

    public function offsetUnset($offset)
    {
        $this->offsetSet($offset, null);
    }

    //
    // get/set
    //

    public function __set($name, $value)
    {
        $methodName = "set".$name;
        if (method_exists($this, $methodName)) {
            call_user_func([$this, $methodName], $value);
        }
        else {
            throw new Exception("Свойство '{$name}' не имеет сеттера, либо не существует");
        }
    }

    public function __get($name)
    {
        $methodName = "get".$name;
        if (method_exists($this, $methodName)) {
            return call_user_func([$this, $methodName]);
        }
        else {
            throw new Exception("Свойство '{$name}' не имеет геттера, либо не существует");
        }
    }
}
