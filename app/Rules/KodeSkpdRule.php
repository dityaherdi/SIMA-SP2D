<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class KodeSkpdRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // sample : 0.00.00.
        if(strlen($value)<8){
            return false;
        }else{
            $kode = str_split($value);
            if ($kode[1] == '.' && $kode[4] == '.' && $kode[7] == '.') {
                return true;
            }
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kode SKPD tidak sesuai';
    }
}
