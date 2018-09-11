<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\KodeSkpdRule;

class FormSkpdRequest extends FormRequest
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
        'kode_skpd' => [''],
        'nama_skpd' => 'required|max:191',
        'alias_skpd' => 'required|max:191'
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
            $rules['kode_skpd'] = ['required', 'max:8', 'unique:skpds', new KodeSkpdRule()];
        }else if ($this->isMethod('PUT')) {
            $rules['kode_skpd'] = ['required', 'max:8', 'unique:skpds,kode_skpd,'.$this->get('id'), new KodeSkpdRule()];
        }
        return $rules;
    }

    public function messages() {
        return [
            'kode_skpd.required' => 'Kode SKPD harus diisi',
            'kode_skpd.max' => 'Kode SKPD maksimal 8 karakter',
            'kode_skpd.unique' => 'Kode SKPD sudah digunakan',
            'nama_skpd.required' => 'Nama SKPD harus diisi',
            'nama_skpd.max' => 'Nama SKPD melebihi batas karakter',
            'alias_skpd.required' => 'Nama alias SKPD harus diisi',
            'alias_skpd.max' => 'Nama alias SKPD melebihi batas karakter',
        ];
    }
}
