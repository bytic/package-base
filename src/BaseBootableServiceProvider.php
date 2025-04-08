<?php

declare(strict_types=1);

namespace ByTIC\PackageBase;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;

/**
 * Class BaseBootableServiceProvider.
 */
abstract class BaseBootableServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{
    use ServiceProviders\HasMigrationsTrait;
    use ServiceProviders\HasRepositoriesTrait;
    use ServiceProviders\HasTranslationsTrait;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [];
    }

    public function boot(): void
    {
        $this->bootMigrations();
        $this->bootTranslations();
    }
}
