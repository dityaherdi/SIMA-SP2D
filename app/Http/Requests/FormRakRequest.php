<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRakRequest extends FormRequest
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
        'id_ruangan' => 'required',
        'kode_rak' => ''
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
            $rules['kode_rak'] = 'required|unique:raks,kode_rak,NULL,id_rak,id_ruangan,'.$this->get('id_ruangan').'';
        }else if ($this->isMethod('PUT')) {
            $rules['kode_rak'] = 'required|unique:raks,kode_rak,'.$this->get('id_rak').',id_rak,id_ruangan,'.$this->get('id_ruangan').'';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'id_ruangan.required' => 'Ruangan masih kosong',
            'kode_rak.required' => 'Kode Rak masih kosong',
            'kode_rak.unique' => 'Kode Rak sudah digunakan pada gedung ini'
        ];
    }
}
