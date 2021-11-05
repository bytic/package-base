<?php

namespace ByTIC\PackageBase;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;

/**
 * Class BaseBootableServiceProvider
 * @package ByTIC\PackageBase
 */
abstract class BaseBootableServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{
    use ServiceProviders\HasMigrationsTrait;

    /**
     * @inheritdoc
     */
    public function register()
    {
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [];
    }

    public function boot()
    {
        $this->bootMigrations();
    }
}
