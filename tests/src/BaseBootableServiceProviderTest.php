<?php

namespace ByTIC\PackageBase\Tests;

use ByTIC\PackageBase\Tests\Fixtures\BasicBootableServiceProvider;

/**
 * Class BaseBootableServiceProviderTest
 * @package ByTIC\PackageBase\Tests
 */
class BaseBootableServiceProviderTest extends AbstractTest
{
    public function test_bootMigrations()
    {
        $provider = new BasicBootableServiceProvider();
        $provider->initContainer();
        $container = $provider->getContainer();

        $mock = \Mockery::mock('foo');
        $mock->shouldReceive('path')->with(TEST_BASE_PATH);
        $container->set('migrations.migrator', $mock);

        $provider->boot();
    }
}