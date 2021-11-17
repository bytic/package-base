<?php

namespace ByTIC\PackageBase\Utility;

use Closure;
use Nip\Container\Utility\Container;
use Psr\Container\ContainerInterface;
use RuntimeException;

/**
 * Class AbstractFacade
 * @package ByTIC\PackageBase\Utility
 */
abstract class AbstractFacade
{

    protected static $container;

    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;


    /**
     * Indicates if the resolved instance should be cached.
     *
     * @var bool
     */
    protected static $cached = true;

    abstract protected static function getFacadeAccessor();

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Resolve the facade root instance from the container.
     *
     * @param string $name
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }
        $container = static::getContainer();
        static::$resolvedInstance[$name] = $container->get($name);
        return static::$resolvedInstance[$name];
    }

    /**
     * Run a Closure when the facade has been resolved.
     *
     * @param \Closure $callback
     * @return void
     */
    public static function resolved(Closure $callback)
    {
        $accessor = static::getFacadeAccessor();

        if (static::$app->resolved($accessor) === true) {
            $callback(static::getFacadeRoot());
        }

        static::$app->afterResolving($accessor, function ($service) use ($callback) {
            $callback($service);
        });
    }

    /**
     * Facade service container.
     */
    public static function setContainer(ContainerInterface $container)
    {
        static::$container = $container;
    }

    /**
     * @return mixed
     */
    public static function getContainer()
    {
        if (self::$container === null) {
            self::$container = Container::container();
        }
        return self::$container;
    }


    /**
     * Handle dynamic calls to the service.
     *
     * @param string $method
     * @param $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}