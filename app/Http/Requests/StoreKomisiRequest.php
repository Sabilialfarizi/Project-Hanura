<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKomisiRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'role_id' => 'required',
            'persentase' => 'required',
            'min_transaksi' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'Select Role.',
            'persentase.required' => 'The persentase field is required.',
            'min_transaksi.required' => 'The min transaksi field is required.',
        ];
    }
}
