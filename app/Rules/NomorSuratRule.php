<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class NomorSuratRule implements Rule
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
        // sample : 00000/SP2D/XX/0.00.00/YYYY
        $currentYear = Carbon::now()->format('Y');
        $str = explode('/', $value);
        if(is_numeric($str[0]) && is_numeric($str[4])){
            if (strlen($str[0]) == 5) {
                if (intval($str[4]) > 1900 && intval($str[4]) <= intval($currentYear)) {
                    return true;
                }
                return false;
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
        return 'Nomor Surat tidak sesuai';
    }
}
