<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BalanceRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $message;

    public function __construct()
    {
        $this->message = '';

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dana = \DB::table('danas')->where('user_id', \Auth::user()->id)->first();

        return $dana->amount >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be greater than or equal amount of dana';
    }
}
