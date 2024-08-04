<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertItemNoteRequest extends FormRequest
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
            'item_transaksi_id' => 'required|exists:item_transaksis,id',
            'catatan' => 'required|string',
            'front_top_left' => 'required|boolean',
            'front_top_right' => 'required|boolean',
            'front_bottom_left' => 'required|boolean',
            'front_bottom_right' => 'required|boolean',
            'back_top_left' => 'required|boolean',
            'back_top_right' => 'required|boolean',
            'back_bottom_left' => 'required|boolean',
            'back_bottom_right' => 'required|boolean',
            'image[]' => 'image',
        ];
    }
}
