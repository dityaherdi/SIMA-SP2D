<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormJenisRequest extends FormRequest
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
            'kode_jenis_sp2d' => 'required|size:2',
            'nama_jenis_sp2d' => 'required|max:191'
        ];
    }

    public function messages()
    {
        return [
            'kode_jenis_sp2d.required' => 'Kode Jenis SP2D harus diisi',
            'kode_jenis_sp2d.size' => 'Kode Jenis SP2D hanya dua huruf',
            'nama_jenis_sp2d.required' => 'Nama Jenis SP2D harus diisi',
            'nama_jenis_sp2d.max' => 'Nama Jenis SP2D melebihi batas karakter',
        ];
    }
}
