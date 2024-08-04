<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertPickupDeliveryRequest extends FormRequest
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
            'pelanggan_id' => 'exists:pelanggans,id',
            'driver_id' => 'exists:users,id',
            'action' => 'string',
            'alamat' => 'string',
            'transaksi_id' => 'exists:transaksis,id',
            'request' => 'string|nullable',
        ];
    }
}
