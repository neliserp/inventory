<?php

namespace Neliserp\Inventory\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Neliserp\Inventory\InventoryServiceProvider;
use Neliserp\Inventory\Item;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            InventoryServiceProvider::class,
        ];
    }

    // *** index ***

    /** @test */
    public function it_can_list_items()
    {
        $items = factory(Item::class, 3)->create();

        $expectedData = $items->toArray();

        $this->json('GET', '/api/items?sort=id')
            ->assertStatus(200)
            ->assertJson([
                'data' => $expectedData,
                'links' => [
                    'first' => 'http://localhost/api/items?page=1',
                    'last' => 'http://localhost/api/items?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => 'http://localhost/api/items',
                    'per_page' => 10,
                    'to' => $items->count(),
                    'total' => $items->count(),
                ],
            ]);
    }

    /** @test */
    public function it_can_search_items_by_code()
    {
        $q_code = 'bbb';

        $item_1 = factory(Item::class)->create(['code' => 'aaa-1']);
        $item_2 = factory(Item::class)->create(['code' => 'bbb-1']);
        $item_3 = factory(Item::class)->create(['code' => 'bbb-2']);
        $item_4 = factory(Item::class)->create(['code' => 'ccc-1']);

        $expectedData = [
            [
                'id' => $item_2->id,
            ],
            [
                'id' => $item_3->id,
            ],
        ];

        $this->json('GET', "/api/items?code={$q_code}")
            ->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => $expectedData,
            ]);
    }

    // *** show ***

    /** @test */
    public function not_found_items_return_404()
    {
        $this->json('GET', '/api/items/9999')
            ->assertStatus(404);
    }

    /** @test */
    public function it_can_view_an_item()
    {
        $item = factory(Item::class)->create();

        $expectedData = $item->toArray();

        $this->json('GET', "/api/items/{$item->id}")
            ->assertStatus(200)
            ->assertJson([
                'data' => $expectedData,
            ]);
    }

    // *** store ***
    /**  @test */
    public function create_an_item_requires_valid_fields()
    {
        $data = [];

        $this->json('POST', '/api/items', $data)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_can_create_an_item()
    {
        $data = factory(Item::class)->raw();

        $this->json('POST', '/api/items', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                ],
            ]);

        $this->assertDatabaseHas('items', $data);
    }

    // *** update ***

    /**  @test */
    public function update_an_item_requires_valid_fields()
    {
        $item = factory(Item::class)->create();

        $data = [];

        $this->json('PUT', "/api/items/{$item->id}", $data)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function update_not_found_items_return_404()
    {
        $data = factory(Item::class)->raw();

        $this->json('PUT', '/api/items/9999', $data)
            ->assertStatus(404);
    }

    /** @test */
    public function user_can_submit_update_with_no_changes()
    {
        $item = factory(Item::class)->create();

        $data = [
            'code' => $item->code,
            'name' => $item->name,
        ];

        $this->json('PUT', "/api/items/{$item->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                ],
            ]);

        $this->assertDatabaseHas('items', $data);
    }

    /** @test */
    public function it_can_update_an_item()
    {
        $item = factory(Item::class)->create();

        $data = factory(Item::class)->raw();

        $this->json('PUT', "/api/items/{$item->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                ],
            ]);

        $this->assertDatabaseHas('items', $data);
    }

    // *** destroy ***

    /** @test */
    public function delete_not_found_items_return_404()
    {
        $this->json('DELETE', '/api/items/9999')
            ->assertStatus(404);
    }

    /** @test */
    public function it_can_delete_an_item()
    {
        $item = factory(Item::class)->create();

        $this->json('DELETE', "/api/items/{$item->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('items', [
            'id' => $item->id,
        ]);
    }
}
