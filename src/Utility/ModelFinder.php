<?php

namespace ByTIC\PackageBase\Utility;

use Nip\Records\Locator\ModelLocator;

/**
 * Class ModelFinder
 * @package ByTIC\PackageBase\Utility
 */
class ModelFinder
{
    protected static $models = [];

    /**
     * @param string $type
     * @param string $default
     * @return mixed|\Nip\Records\AbstractModels\RecordManager
     */
    protected static function getModels($type, $default)
    {
        if (!isset(static::$models[$type])) {
            $repository = static::getConfigVar($type, $default);
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
        if (!function_exists('config')) {
            return $default;
        }
        $varName = 'notifier-builder.models.' . $type;
        $config = config();
        if ($config->has($varName)) {
            return $config->get($varName);
        }
        return $default;
    }

}