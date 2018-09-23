<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\KodeRuanganRule;

class FormRuanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->hasHeader('Authorization')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_gedung' => 'required',
            'kode_ruangan' => ['required', new KodeRuanganRule($this->id_gedung, $this->kode_ruangan)]
        ];
    }

    public function messages()
    {
        return [
            'id_gedung.required' => 'Gedung harus diisi',
            'kode_ruangan.required' => 'Kode Ruangan harus diisi'
        ];
    }
}
