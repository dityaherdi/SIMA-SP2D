<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormUserRequest extends FormRequest
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
        'nip' => '',
        'nama' => 'required|min:4|max:191',
        'username' => '',
        'password' => 'sometimes|required|min:6',
        'tipe' => 'required',

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
            $rules['nip'] = 'required|regex:/[0-9 ]+/|size:21|unique:users,nip';
            $rules['username'] = 'required|min:4|unique:users,username';
        }else if ($this->isMethod('PUT')) {
            $rules['nip'] = 'required|regex:/[0-9 ]+/|size:21|unique:users,nip,'.$this->get('id_user').',id_user';
            $rules['username'] = 'required|min:4|unique:users,username,'.$this->get('id_user').',id_user';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'nip.required' => 'NIP harus diisi',
            'nip.regex' => 'NIP harus berupa angka',
            'nip.size' => 'NIP harus 1-21 karakter',
            'nip.unique' => 'NIP sudah digunakan',
            'nama.required' => 'Nama harus diisi',
            'nama.min' => 'Nama minimal 4 karakter',
            'nama.max' => 'Nama melebihi batas karakter',
            'username.required' => 'Username harus diisi',
            'username.min' => 'Username minimal 4 karakter',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'tipe.required' => 'Tipe harus diisi',
        ];
    }
}
