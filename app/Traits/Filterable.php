<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable {

    public function scopeFilter(Builder $builder)
    {
        $appliedFilters = request('filter');
        $appliableFilters = array_intersect($this->filterable, array_keys($appliedFilters));

        foreach ($appliableFilters as $key => $filter) {
            $value = explode(',', $appliedFilters[$filter]);
            $builder->whereIn($filter, $value);
        }
        return $builder;
    }
}
