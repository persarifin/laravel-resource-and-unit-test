<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|min:7|unique:users',            
            'password' => 'required|min:5|confirmed',
            'address' => 'required',
        ];        
    }
    public function messages()
    {
        return $messages = [
            'email.email' => ':attribute invalid format!, example@email.com',
            'email.unique' => ':attribute do not match',
            'username.unique' => ':attribute not available',
            'username.min' => ':attribute must be at least 8 character',
        ];

    }
}
