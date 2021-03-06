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

    protected $rules = [
        'id_gedung' => 'required',
        'kode_ruangan' => ''
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
            $rules['kode_ruangan'] = 'required|unique:ruangans,kode_ruangan,NULL,id_ruangan,id_gedung,'.$this->get('id_gedung').'';
        }else if ($this->isMethod('PUT')) {
            $rules['kode_ruangan'] = 'required|unique:ruangans,kode_ruangan,'.$this->get('id_ruangan').',id_ruangan,id_gedung,'.$this->get('id_gedung').'';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'id_gedung.required' => 'Gedung harus diisi',
            'kode_ruangan.required' => 'Kode Ruangan harus diisi',
            'kode_ruangan.unique' => 'Kode Ruangan sudah digunakan pada gedung ini',
        ];
    }
}
