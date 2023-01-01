<?php

declare(strict_types=1);

namespace ByTIC\PackageBase\Tests\Fixtures\Utility;

use ByTIC\PackageBase\Utility\AbstractFacade;

/**
 * Class BaseFacade.
 */
class BaseFacade extends AbstractFacade
{
    protected static function getFacadeAccessor()
    {
        return 'test';
    }
}
