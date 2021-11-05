<?php

namespace ByTIC\PackageBase\Utility;

/**
 * Class PackageConfig
 * @package ByTIC\PackageBase\Utility
 */
abstract class PackageConfig
{
    protected static $cache = [];
    public const NAME = null;

    /**
     * @param string $type
     * @param null|string $default
     * @return string
     */
    public static function value(string $type, $default = null)
    {
        if (isset(static::$cache[$type])) {
            return static::$cache[$type];
        }

        if (!function_exists('config')) {
            return $default;
        }

        $varName = self::NAME . '.' . $type;
        $config = config();
        if ($config->has($varName) === false) {
            return $default;
        }

        $value = $config->get($varName);
        static::$cache[$type] = $value;
        return $value;
    }
}
