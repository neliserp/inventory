<?php

namespace Neliserp\Inventory;

use Illuminate\Database\Eloquent\Model;
use Neliserp\Inventory\Filters\ItemFilter;

class Item extends Model
{
    protected $guarded = [];

    public function scopeFilter($builder, ItemFilter $filter)
    {
        return $filter->apply($builder);
    }
}
