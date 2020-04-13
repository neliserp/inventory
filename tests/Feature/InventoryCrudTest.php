<?php

namespace Neliserp\Inventory\Tests\Feature;

use Neliserp\Core\Tests\CrudTest;
use Neliserp\Inventory\InventoryServiceProvider;

abstract class InventoryCrudTest extends CrudTest
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            InventoryServiceProvider::class,
        ];
    }
}
