<?php

namespace Neliserp\Inventory\Filters;

class ItemFilter extends Filter
{
    protected function code($code)
    {
        return $this->builder->where('code', 'LIKE', "%{$code}%");
    }

    protected function name($name)
    {
        return $this->builder->where('name', 'LIKE', "%{$name}%");
    }

    protected function q($q)
    {
        return $this->builder->where(function ($query) use ($q) {
            $query->where('code', 'LIKE', "%{$q}%")
                ->orWhere('name', 'LIKE', "%{$q}%");
        });
    }
}
