<?php

namespace Rpsv\Main;

use ReflectionClass;

class Container
{
	public static function createObject(string $className)
    {
        static $instances = [];

        if (isset($instances[$className])) {
            return $instances[$className];
        }

        $ref = new ReflectionClass($className);
        $refContructor = $ref->getConstructor();
        if ($refContructor) {
            $args = [];
            $refArgs = $refContructor->getParameters();
            foreach ($refArgs as $refArg) {
                if ($refArgClass = $refArg->getClass()) {
                    $args[] = $refArgClass->newInstance();
                }
                else if ($refArg->isOptional()) {
                    $args[] = $refArg->getDefaultValue();
                }
                else {
                    $args[] = null;
                }
            }
            return $instances[$className] = $ref->newInstanceArgs($args);
        }
        return $instances[$className] = $ref->newInstance();
    }

    // public static function getTestService(): TestService
    // {
    //     return self::createObject(TestService::class);
    // }
}
