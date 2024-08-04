<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertJenisItemRequest extends FormRequest
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
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|string',
            'unit' => 'required|string',
            'bobot_bucket' => 'required|numeric',
            'harga_kilo' => 'required|numeric',
            'harga_bucket' => 'required|numeric',
            'harga_premium' => 'required|numeric',
            'status_kilo' => 'required|boolean',
            'status_bucket' => 'required|boolean',
            'status_premium' => 'required|boolean',
            'beban_produksi' => 'numeric',
        ];
    }
}
