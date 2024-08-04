<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus terisi!',
            'exists' => ':attribute tidak ditemukan!'
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }
}
