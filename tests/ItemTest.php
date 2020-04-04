<?php

namespace Neliserp\Inventory\Tests;

use Orchestra\Testbench\TestCase;

use Neliserp\Inventory\InventoryServiceProvider;
use Neliserp\Inventory\Item;

class ItemTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            InventoryServiceProvider::class,
        ];
    }

    /** @test */
    public function just_test_route()
    {
        $this->get('items')
            ->assertStatus(200)
            ->assertSee('index');
    }
}
