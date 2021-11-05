<?php

namespace ByTIC\PackageBase\Utility;

use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PackageConfig
 * @package ByTIC\PackageBase\Utility
 */
class PackageConfig
{
    use SingletonTrait;

    protected $cache = [];
    protected $name = null;

    /**
     * @param string $type
     * @param null|string $default
     * @return string
     */
    public static function value(string $type, $default = null)
    {
        return static::instance()->get($type, $default);
    }

    public static function name(string $type, $default = null)
    {
        return static::instance()->setName($name);
    }

    /**
     * @param string $type
     * @param null $default
     * @return mixed|\Nip\Config\Config|string|null
     * @throws \Exception
     */
    public function get(string $type, $default = null)
    {
        if (isset($this->cache[$type])) {
            return $this->cache[$type];
        }

        if (!function_exists('config')) {
            return $default;
        }

        $varName = $this->name . '.' . $type;
        $config = config();
        if ($config->has($varName) === false) {
            return $default;
        }

        $value = $config->get($varName);
        $this->cache[$type] = $value;
        return $value;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
