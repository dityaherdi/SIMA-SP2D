<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormArsipRequest extends FormRequest
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
            'id_box' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'id_box.required' => 'Kode Box harus diisi, Letak pengarsipan belum lengkap'
        ];
    }
}
