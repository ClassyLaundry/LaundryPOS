<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertPenerimaRequest extends FormRequest
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
            'transaksi_id' => 'required|exists:transaksis,id',
            'ambil_di_outlet' => 'nullable|boolean',
            'outlet_id' => 'nullable|exists:outlets,id',
            'tanggal_penerimaan' => 'nullable|date',
            'penerima' => 'nullable|string',
            'image' => 'nullable|image',
        ];
    }
}
