<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormBoxRequest extends FormRequest
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

    protected $rules = [
        'id_rak' => 'required',
        'kode_box' => ''
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->rules;
        if ($this->isMethod('POST')) {
            $rules['kode_box'] = 'required|unique:boxes,id_box,NULL,id_box,id_rak,'.$this->get('id_rak').'';
        }else if ($this->isMethod('PUT')) {
            $rules['kode_box'] = 'required|unique:boxes,id_box,'.$this->get('id_box').',id_box,id_rak,'.$this->get('id_rak').'';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'id_rak.required' => 'Rak harus diisi',
            'kode_box.required' => 'Kode Box harus diisi, Letak pengarsipan belum lengkap',
            'kode_box.unique' => 'Kode Box sudah digunakan pada rak ini'
        ];
    }
}
