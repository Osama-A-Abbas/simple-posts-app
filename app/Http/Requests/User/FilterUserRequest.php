<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequests\FilterableRequest;

class FilterUserRequest extends FilterableRequest
{

    // Define available fields and their validation rules.
    protected function filterable(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|exists:users,email',
        ];
    }

    // Define allowed filters per role.
    protected function roleFilters(): array
    {
        return [

        ];
    }


    // Define allowed filters per permission.
    protected function permissionFilters(): array
    {
        return [

        ];
    }

    //the default authorize function allows only Auth users but it can be overran
    // public function authorize(): bool
    // {
    //     return true;
    // }
}
