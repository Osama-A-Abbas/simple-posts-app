<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $this->user()->id,
            'password' => [
                'sometimes',
                'string',
                'min:8',
                'max:24',
                'regex:/[A-Z]/',       // Uppercase
                'regex:/[a-z]/',       // Lowercase
                'regex:/[0-9]/',       // Number
                'regex:/[@$!%*?&#]/',  // Special char
            ],
        ];
    }
}
