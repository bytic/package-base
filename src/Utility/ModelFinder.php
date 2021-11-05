<?php

namespace ByTIC\PackageBase\Utility;

use Nip\Records\Locator\ModelLocator;
use ReflectionClass;

/**
 * Class ModelFinder
 * @package ByTIC\PackageBase\Utility
 */
abstract class ModelFinder
{
    /**
     * @var null|PackageConfig
     */
    protected static $config = null;
    protected static $models = [];

    /**
     * @param string $type
     * @param string $default
     * @return mixed|\Nip\Records\AbstractModels\RecordManager
     */
    protected static function getModels($type, $default)
    {
        if (!isset(static::$models[$type])) {
            $repository = static::getConfigVar('models.' . $type, $default);
            return static::$models[$type] = ModelLocator::get($repository);
        }

        return static::$models[$type];
    }

    /**
     * @param string $type
     * @param null|string $default
     * @return string
     */
    protected static function getConfigVar($type, $default = null)
    {
        return self::autoInitConfig()->get($type, $default);
    }

    protected static function autoInitConfig(): ?PackageConfig
    {
        if (static::$config !== null) {
            return static::$config;
        }

        $currentClass = static::class;
        $refl = new ReflectionClass($currentClass);
        $namespace = $refl->getNamespaceName();

        $class = $namespace . '\\PackageConfig';
        if (class_exists($class)) {
            static::$config = new $class();
            return static::$config;
        }
        static::$config = new PackageConfig();
        static::$config->setName(static::packageName());
        return static::$config;
    }

    abstract protected static function packageName(): string;
}