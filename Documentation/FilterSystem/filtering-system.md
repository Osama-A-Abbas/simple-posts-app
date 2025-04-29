# Filtering System Documentation

## Overview
The filtering system in this project provides a flexible way to filter model data based on request parameters. It's implemented using a combination of a trait-based approach and request validation classes.

## Core Components

### 1. Filterable Trait
Located at `app/Traits/Filterable.php`, this trait provides the core filtering functionality:

```php
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
```

### 2. FilterableRequest Abstract Class
The `FilterableRequest` abstract class provides a base for all filter request classes. It defines three key methods that must be implemented:

1. `filterable()`: Defines available fields and their validation rules
2. `roleFilters()`: Defines allowed filters per role
3. `permissionFilters()`: Defines allowed filters per permission

Example implementation in `FilterPostRequest`:
```php
class FilterPostRequest extends FilterableRequest
{
    protected function filterable(): array
    {
        return [
            'content' => 'sometimes|string|max:5000',
            'user_id' => 'sometimes|email|exists:users,email',
        ];
    }

    protected function roleFilters(): array
    {
        return [];
    }

    protected function permissionFilters(): array
    {
        return [];
    }
}
```

### 3. Model Implementation
Models that need filtering capabilities should:
1. Use the `Filterable` trait
2. Define a `$filterable` property with the list of filterable attributes

Example from the User model:
```php
use App\Traits\Filterable;

class User extends Authenticatable
{
    use Filterable;
    
    protected $filterable = [
        'name',
        'email',
    ];
}
```

Example from the Post model:
```php
use App\Traits\Filterable;

class Post extends Model
{
    use Filterable;
    
    protected $filterable = [
        'user_id',
        'content',
    ];
}
```

## Usage

### API Endpoints
The filtering system is exposed through dedicated API endpoints that use the filter request classes:

1. User Filtering:
```php
Route::get('users-filter', function (FilterUserRequest $request) {
    return User::query()->filter()->get();
});
```

2. Post Filtering:
```php
Route::get('posts-filter', function (FilterPostRequest $request) {
    return Post::query()->filter()->get();
});
```

### How to Use
To filter data, send a GET request with filter parameters in the following format:
```
GET /api/users-filter?filter[name]=John&filter[email]=john@example.com
GET /api/posts-filter?filter[user_id]=1&filter[content]=example
```

Multiple values for the same filter can be provided using arrays:
```
GET /api/users-filter?filter[name][]=John&filter[name][]=Jane
```

## How It Works

### 1. Request Validation
1. The request is first validated by the appropriate `FilterableRequest` class
2. The `filterable()` method defines which fields can be filtered and their validation rules
3. The `roleFilters()` and `permissionFilters()` methods can restrict filtering based on user roles/permissions

### 2. Filter Application
1. The `Filterable` trait's `scopeFilter` method processes the validated request
2. For each valid filter:
   - If the value is an array, applies a `whereIn` clause
   - If the value is a single value, applies a `where` clause
3. Returns the filtered results

### 3. Security
- Only predefined filterable attributes are processed
- SQL injection is prevented through Laravel's query builder
- Role and permission-based restrictions can be implemented
- Request validation ensures data integrity

## Best Practices

1. **Define Filterable Attributes**:
   - Only include attributes that are safe to filter on
   - Consider performance implications for large datasets

2. **Request Validation**:
   - Implement proper validation rules in the `filterable()` method
   - Use role and permission-based restrictions when needed
   - Validate data types and formats

3. **API Usage**:
   - Use the dedicated filter endpoints for filtering operations
   - Combine filters as needed for complex queries
   - Follow the proper request format

4. **Error Handling**:
   - Invalid filter parameters are rejected by validation
   - Non-existent filterable attributes are not processed
   - Role/permission violations are handled appropriately

## Limitations

1. Currently supports only exact matches through `where` and `whereIn`
2. Does not support complex filtering operations (AND/OR conditions)
3. Limited to attributes defined in the `$filterable` array
4. Role and permission-based filtering must be explicitly implemented

## Future Improvements

1. Add support for different comparison operators (>, <, LIKE, etc.)
2. Implement complex filtering conditions
3. Add validation for filter values
4. Support for relationship filtering
5. Add caching for frequently used filters
6. Implement pagination for filtered results
7. Add sorting capabilities
8. Support for nested filtering 
