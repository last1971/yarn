<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    private $rules = [
        'checkToken' => [
            'token' => 'required|string',
        ],
        'forgot' => [
            'email' => 'required|string|email'
        ],
        'login' => [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ],
        'register' => [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ],
        'resetPassword' => [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required|string'
        ],
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->rules[$this->route()->getName()];
    }
}
