<?php

namespace Neliserp\Inventory\Http\Controllers;

use Illuminate\Routing\Controller;
use Neliserp\Inventory\Item;
use Neliserp\Inventory\Filters\ItemFilter;
use Neliserp\Inventory\Http\Requests\ItemRequest;
use Neliserp\Inventory\Http\Resources\ItemResource;

class ItemController extends Controller
{
    protected $per_page;

    public function __construct()
    {
        $this->per_page = request('per_page', 10);
    }

    public function index()
    {
        $items = Item::filter(new ItemFilter())
            ->paginate($this->per_page);

        return ItemResource::collection($items);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

        return new ItemResource($item);
    }

    public function store(ItemRequest $request)
    {
        $data = $request->toArray();

        $item = Item::create($data);

        return new ItemResource($item);
    }

    public function update(ItemRequest $request, $id)
    {
        $item = Item::findOrFail($id);

        $updated = $item->update($request->toArray());

        return new ItemResource($item);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        $deleted = $item->delete();

        return response([], 200);
    }
}
