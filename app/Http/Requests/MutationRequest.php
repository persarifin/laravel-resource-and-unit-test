<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\BalanceRule;

class MutationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount'   => ['required','numeric','gt:0', new BalanceRule],
            'to_phone' => 'required|numeric'
        ];
    }
}
