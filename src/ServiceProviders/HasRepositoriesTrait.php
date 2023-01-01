<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\ServiceProviders;

use Nip\Records\Locator\ModelLocator;

trait HasRepositoriesTrait
{
    /**
     * @param string $name
     * @param string $class
     */
    protected function addRepositoryNamespace($namespace)
    {
        ModelLocator::instance()->getConfiguration()->addNamespace($namespace);
    }
}
