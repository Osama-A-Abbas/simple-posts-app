<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable {

    public function scopeFilter(Builder $query)
    {
        $filters = request('filter', []);

        foreach ($filters as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query;
    }
}

