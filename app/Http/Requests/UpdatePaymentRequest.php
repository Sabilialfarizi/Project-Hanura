<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
            'nama_metode' => 'required',
            'potongan' => 'required',
            'rekening' => 'required',
            'cabang_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_metode.required' => 'The nama field is required.',
            'potongan.required' => 'The potongan field is required.',
            'rekening.required' => 'The rekening field is required.',
            'cabang_id.required' => 'Please select cabang',
        ];
    }
}
