<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertPaketCuciRequest extends FormRequest
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
            'nama_paket' => 'required|string',
            'deskripsi' => 'nullable|string',
            'harga_paket' => 'numeric',
            'harga_per_bobot' => 'numeric',
            'jumlah_bobot' => 'numeric',
            'status' => 'boolean',
        ];
    }
}
