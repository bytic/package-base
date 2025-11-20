<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\Utility;

use Nip\Records\AbstractModels\RecordManager;
use Nip\Records\Locator\ModelLocator;

/**
 * Class ModelFinder.
 */
abstract class ModelFinder
{
    protected static ?PackageConfig $config = null;

    protected static array $models = [];

    protected static array $modelsClass = [];
    protected static array $tables = [];

    /**
     * @return mixed|RecordManager
     */
    protected static function getModels(string $type, string $default)
    {
        $key = static::keyCreate($type);
        if (!isset(static::$models[$key])) {
            $repository_class = static::getModelsClass($type, $default);
            $repository = ModelLocator::get($repository_class);
            ModelLocator::set($repository->getController(), $repository);

            return static::$models[$key] = $repository;
        }

        return static::$models[$key];
    }

    protected static function getModelsClass(string $type, string $default): string
    {
        $key = static::keyCreate($type);
        if (!isset(static::$modelsClass[$key])) {
            $repository_class = static::getConfigVar('models.' . $type, $default);
            return static::$modelsClass[$key] = $repository_class;
        }

        return static::$modelsClass[$key];
    }

    /**
     * @param string $type
     * @param string|null $default
     * @return mixed|string
     * @throws \Exception
     */
    protected static function getTable(string $type, ?string $default = null): string
    {
        $key = static::keyCreate($type);
        if (!isset(static::$tables[$key])) {
            $default = $default ?: self::getModels($type, $type)->getTable();
            $table = static::getConfigVar('tables.' . $type, $default);

            return static::$tables[$key] = $table;
        }

        return static::$tables[$key];
    }

    protected static function keyCreate($key): string
    {
        $current_class = static::class;
        return $current_class . '::' . $key;
    }

    /**
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
        if (null !== static::$config) {
            return static::$config;
        }

        $current_class = static::class;
        $reflection = new \ReflectionClass($current_class);
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
