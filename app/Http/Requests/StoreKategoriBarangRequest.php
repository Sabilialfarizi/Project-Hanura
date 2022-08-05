<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKategoriBarangRequest extends FormRequest
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
         
            'nama_kategori' => 'required',
            'created_at' => 'required',
         
        ];
    }
    public function messages()
    {
        return [
       
            'nama_kategori.required' => 'The nama Kategori field is required.',
            'created_at.required' => 'The Tanggal field is required.',
         
        ];
    }
}
