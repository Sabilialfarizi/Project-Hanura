<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UpdateWarehouseRequest extends FormRequest
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
            'nama' => 'required',
            'id_perusahaan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'The nama field is required.',
            'id_perusahaan.required' => 'The nama perusahaan field is required.',
            
        ];
    }
}
