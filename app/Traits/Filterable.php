<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable {

    /**
 * Apply dynamic filters on the query based on the request input.
 *
 * This scope looks for a 'filter' parameter in the request, checks which fields are allowed to be filtered
 * (defined in the model's $filterable property), and automatically applies "whereIn" conditions
 * based on the matching request inputs.
 *
 * @param \Illuminate\Database\Eloquent\Builder $builder
 * @return \Illuminate\Database\Eloquent\Builder
 */
public function scopeFilter(Builder $builder)
{
    // Get the 'filter' array from the request query parameters (e.g., ?filter[field]=value)
    $appliedFilters = request('filter');

    // Find the intersection between model's allowed filters and the requested filters
    // This ensures users can only filter by fields you explicitly allowed
    $appliableFilters = array_intersect($this->filterable, array_keys($appliedFilters));

    // Loop through each allowed filter field
    foreach ($appliableFilters as $key => $filter) {
        // Get the value from the request for that filter, and split by comma to support multiple values
        $value = explode(',', $appliedFilters[$filter]);

        // Apply a whereIn query for this filter field and its value(s)
        $builder->whereIn($filter, $value);
    }

    // Return the modified query builder
    return $builder;
}

    //Basic function with no comments
    // public function scopeFilter(Builder $builder)
    // {
    //     $appliedFilters = request('filter');
    //     $appliableFilters = array_intersect($this->filterable, array_keys($appliedFilters));

    //     foreach ($appliableFilters as $key => $filter) {
    //         $value = explode(',', $appliedFilters[$filter]);
    //         $builder->whereIn($filter, $value);
    //     }
    //     return $builder;
    // }
}

