<?php

namespace ByTIC\PackageBase\ServiceProviders;

/**
 * Trait HasMigrationsTrait
 * @package ByTIC\PackageBase\ServiceProviders
 */
trait HasMigrationsTrait
{
    /**
     * @param string|array $path
     */
    protected function loadMigrationsFrom($paths)
    {
        foreach ((array)$paths as $path) {
            $this->getContainer()->get('migrations.migrator')->path($path);
        }
    }

    protected function bootMigrations()
    {
        if (method_exists($this, 'migrations')) {
            $this->loadMigrationsFrom($this->migrations());
            return;
        }
    }
}