<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
    }
    public function messages()
    {
        return $messages = [
            'email.required' => 'The email field is required. You can input email, phone or username',
        ];

    }
}
