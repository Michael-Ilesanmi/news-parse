<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('login')) {
            return [
                'email'=>'required|email',
                'password'=>'required|min:6'
            ];
        }
        return [];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'email.required' => 'An email is required',
            'email.email' => 'Please enter a valid email',
            'password.required' => 'Your password is required',
            'password.min' => 'Password must be minimum of 6 characters',
        ];
    }
}
