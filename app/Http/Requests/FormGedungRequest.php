<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormGedungRequest extends FormRequest
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
        'kode_gedung' => '',
        'nama_gedung' => 'required|max:191',
        'alamat' => 'required'
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
            $rules['kode_gedung'] = 'required|unique:gedungs';
        }else if ($this->isMethod('PUT')) {
            $rules['kode_gedung'] = 'required|unique:gedungs,kode_gedung,'.$this->get('id_gedung').',id_gedung';            
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'kode_gedung.required' => 'Kode Gedung harus diisi',
            'kode_gedung.unique' => 'Kode Gedung sudah digunakan',
            'nama_gedung.required' => 'Nama Gedung harus diisi',
            'nama_gedung.max' => 'Nama Gedung melebihi batas karakter',
            'alamat.required' => 'Alamat harus diisi'
        ];
    }
}
