<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'email' => 'required|email',
            'status' => 'boolean',
            'role' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus terisi!',
            'unique' => ':attribute sudah terdaftar!',
            'email' => 'Format :attribute tidak valid!',
            'numeric' => 'Harap isi :attribute dengan angka saja',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'phone' => 'Nomor Telepon',
            'address' => 'Alamat',
            'name' => 'Nama',
            'email' => 'Email'
        ];
    }
}
