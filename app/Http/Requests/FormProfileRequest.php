<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormProfileRequest extends FormRequest
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
        'nama' => 'required|min:4|max:191',
        'username' => '',
        'password' => 'sometimes|nullable|min:6',
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
            $rules['username'] = 'required|min:4|unique:users,username';
        }else if ($this->isMethod('PUT')) {
            $rules['username'] = 'required|min:4|unique:users,username,'.$this->get('id_user').',id_user';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama harus diisi',
            'nama.min' => 'Nama minimal 4 karakter',
            'nama.max' => 'Nama melebihi batas karakter',
            'username.required' => 'Username harus diisi',
            'username.min' => 'Username minimal 4 karakter',
            'username.unique' => 'Username sudah digunakan',
            'password.min' => 'Password minimal 6 karakter',
        ];
    }
}
