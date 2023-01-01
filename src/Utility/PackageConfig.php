<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\Utility;

use Nip\Utility\Traits\SingletonTrait;

/**
 * Class PackageConfig.
 */
class PackageConfig
{
    use SingletonTrait;

    protected $cache = [];
    protected $name = null;

    /**
     * @param string|null $default
     *
     * @return string
     */
    public static function value(string $type, $default = null)
    {
        return static::instance()->get($type, $default);
    }

    public static function name(string $type)
    {
        return static::instance()->setName($type);
    }

    /**
     * @param null $default
     *
     * @return mixed|\Nip\Config\Config|string|null
     *
     * @throws \Exception
     */
    public function get(string $type, $default = null)
    {
        if (isset($this->cache[$type])) {
            return $this->cache[$type];
        }

        if (!\function_exists('config')) {
            return $default;
        }

        $varName = $this->name . '.' . $type;
        if (false === app()->has('config')) {
            return $default;
        }
        $config = config();
        if (false === $config->has($varName)) {
            return $default;
        }

        $value = $config->get($varName);
        $this->cache[$type] = $value;

        return $value;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
