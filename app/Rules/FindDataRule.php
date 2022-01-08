<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FindDataRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $table;
    
    public function __construct($table)
    {
        $this->table = $table;
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
        $data = \DB::table($this->table)->where('id', $value)->first();
        
        return isset($data);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'data not found.';
    }
}
