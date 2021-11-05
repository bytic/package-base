<?php

namespace ByTIC\PackageBase\Tests\Fixtures;

use ByTIC\PackageBase\BaseBootableServiceProvider;

class BasicBootableServiceProvider extends BaseBootableServiceProvider
{
    /**
     * @return string
     */
    public function migrations()
    {
        return TEST_BASE_PATH;
    }
}
