<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NomorSuratRule;

class FormSuratRequest extends FormRequest
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
        'id_skpd' => 'required',
        'id_jenis_sp2d' => 'required',
        'nomor_surat' => ''
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
            $rules['nomor_surat'] = ['required', 'unique:surats', new NomorSuratRule()];
        }else if ($this->isMethod('PUT')) {
            $rules['nomor_surat'] = ['required', 'unique:surats,nomor_surat, '.$this->get('id_sp2d').',id_sp2d', new NomorSuratRule()];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'id_skpd.required' => 'SKPD harus diisi',
            'id_jenis_sp2d.required' => 'Jenis SP2D harus diisi',
            'nomor_surat.required' => 'Nomor Surat harus diisi',
            'nomor_surat.unique' => 'Nomor Surat sudah digunakan'
        ];
    }
}