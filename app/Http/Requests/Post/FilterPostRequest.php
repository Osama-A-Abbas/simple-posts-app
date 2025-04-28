<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FilterPostRequest extends FormRequest
{
     // Define available fields and their validation rules.
     protected function filterable(): array
     {
         return [
             'content' => 'sometimes|string|max:5000',
             'user_id' => 'sometimes|email|exists:users,email',
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
}
