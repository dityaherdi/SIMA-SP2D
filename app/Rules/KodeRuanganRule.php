<?php

namespace App\Rules;

use App\Ruangan;
use Illuminate\Contracts\Validation\Rule;

class KodeRuanganRule implements Rule
{
    public $id_gedung;
    public $kode_ruangan;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id_gedung, $kode_ruangan)
    {
        $this->id_gedung = $id_gedung;
        $this->kode_ruangan = $kode_ruangan;
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
        $exist = Ruangan::where(['id_gedung' => $this->id_gedung, 'kode_ruangan' => $this->kode_ruangan])->count();
        if ($exist==0) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kode Ruangan sudah digunakan pada gedung yang sama';
    }
}
