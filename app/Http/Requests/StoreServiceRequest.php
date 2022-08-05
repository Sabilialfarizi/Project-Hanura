<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'durasi' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'kode_barang.required' => 'The kode service field is required.',
            'nama_barang.required' => 'The nama field is required.',
            'kode_barang.unique' => 'The kode service has already been taken.',
            'durasi.required' => 'The durasi field is required.',
        ];
    }
}
