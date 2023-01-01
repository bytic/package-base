<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest.
 */
abstract class AbstractTest extends TestCase
{
    use MockeryPHPUnitIntegration;
}
