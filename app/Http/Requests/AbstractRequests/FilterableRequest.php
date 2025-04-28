<?php

namespace App\Http\Requests\AbstractRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Base abstract class for filterable requests.
 *
 * Handles dynamic validation of filter inputs based on user's permissions or roles.
 */
abstract class FilterableRequest extends FormRequest
{
    /**
     * Define available fields and their validation rules.
     *
     * Child classes must implement this method.
     */
    abstract protected function filterable():array;


    /**
     * Define allowed filters per role.
     *
     * Child classes can override to specify role-based filtering.
     */
    protected function roleFilters():array
    {
        return []; // Default: no role-based filters
    }



     /**
     * Define allowed filters per permission.
     *
     * Child classes can override to specify permission-based filtering.
     */
    protected function permissionFilters(): array
    {
        return []; // Default: no permission-based filters
    }



    /**
     * Determine if the user is authorized to make this request.
     *
     * Default: only authenticated users can filter.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * Build the validation rules dynamically based on user's permissions or roles.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $allowedFilters = [];

        // Step 1: Prefer permission-based filtering if user has any relevant permissions
        foreach ($this->permissionFilters() as $permission => $filters) {
            if ($user->can($permission)) {
                $allowedFilter = array_merge($allowedFilters, $filters);
            }
        }

        // Step 2: If no permissions matched, fallback to role-based filtering
        if (empty($allowedFilter)) {
            foreach ($this->roleFilters() as $role => $filters) {
                if ($user->hasRole($role)) {
                    $allowedFilter = array_merge($allowedFilter, $filters);
                }
            }
        }

        // Step 3: Build the validation rules for only allowed fields
        $rules = [];

        foreach ($allowedFilters as $field) {
            // If specific validation rules are defined for the field, use them
            // Otherwise, fallback to generic string validation
            $rules["filter.$field"] = $this->filterable()[$field] ?? ['string'];
        }

        return $rules;
    }


    /**
     * Customize validation error messages for filters.
     */
    public function messages(): array
    {
        return [
            'filter.*.in' => 'The selected :attribute is invalid.',
            'filter.*.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
