<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\Utility;

use Nip\Records\AbstractModels\RecordManager;
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
    protected static ?PackageConfig $config = null;

    protected static array $models = [];

    /**
     * @param string $type
     * @param string $default
     * @return mixed|RecordManager
     */
    protected static function getModels(string $type, string $default)
    {
        if (!isset(static::$models[$type])) {
            $repository_class = static::getConfigVar('models.' . $type, $default);
            $repository = ModelLocator::get($repository_class);
            ModelLocator::set($repository->getController(), $repository);
            return static::$models[$type] = $repository;
        }

        return static::$models[$type];
    }

    /**
     * @param string $type
     * @param string|null $default
     * @return string
     * @throws \Exception
     */
    protected static function getConfigVar(string $type, string $default = null): string
    {
        return self::autoInitConfig()->get($type, $default);
    }

    /**
     * @throws \ReflectionException
     */
    protected static function autoInitConfig(): ?PackageConfig
    {
        if (static::$config !== null) {
            return static::$config;
        }

        $current_class = static::class;
        $reflection = new ReflectionClass($current_class);
        $namespace = $reflection->getNamespaceName();

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