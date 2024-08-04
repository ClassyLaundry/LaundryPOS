<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransaksiRequest extends FormRequest
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
            'parfum_id' => 'exists:parfums,id',
            'express' => 'boolean',
            'setrika_only' => 'boolean',
            'catatan' => 'string|nullable',
            'tipe_transaksi' => 'string',
        ];
    }
}
