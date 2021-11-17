<?php

namespace ByTIC\PackageBase\Tests\Fixtures\Utility;

use ByTIC\PackageBase\Utility\AbstractFacade;

/**
 * Class BaseFacade
 * @package ByTIC\PackageBase\Tests\Fixtures\Utility
 */
class BaseFacade extends AbstractFacade
{

    protected static function getFacadeAccessor()
    {
        return 'test';
    }
}
