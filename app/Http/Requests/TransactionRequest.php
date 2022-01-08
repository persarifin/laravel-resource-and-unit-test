<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FindDataRule;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'wallet_id' => ['required', 'numeric', new FindDataRule('wallets')],
            'amount'  => 'numeric|gt:0', 
        ];
    }
}
