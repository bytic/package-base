<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\Tests\Utility;

use ByTIC\PackageBase\Tests\AbstractTest;
use ByTIC\PackageBase\Tests\Fixtures\Utility\BaseFacade;
use Nip\Container\Utility\Container;

/**
 * Class AbstractUtilityTest.
 */
class AbstractUtilityTest extends AbstractTest
{
    public function testBasic()
    {
        $facadeRoot = \Mockery::mock('service');
        $facadeRoot->shouldReceive('readTemp')
            ->times(3)
            ->andReturn(10, 12, 14);

        $container = Container::container();
        $container->set('test', $facadeRoot);

        self::assertSame(10, BaseFacade::readTemp());
        self::assertSame(12, BaseFacade::readTemp());
        self::assertSame(14, BaseFacade::readTemp());
    }
}
