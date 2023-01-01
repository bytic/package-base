<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\Tests;

use ByTIC\PackageBase\Tests\Fixtures\BasicBootableServiceProvider;

/**
 * Class BaseBootableServiceProviderTest.
 */
class BaseBootableServiceProviderTest extends AbstractTest
{
    public function testBootMigrations()
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
