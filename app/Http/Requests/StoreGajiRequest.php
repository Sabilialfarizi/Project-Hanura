<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGajiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'pegawai_id' => 'required|unique:penggajians,pegawai_id',
            'bulan_tahun' => 'required|unique:penggajians,bulan_tahun',
            'total_potongan' => 'required',
            'total' => 'required',
      
        ];
    }
    public function messages()
    {
        return [
            'tanggal.required' => 'The kode voucher field is required.',
            'pegawai_id.required' => 'The tanggal mulai field is required.',
            'bulan_tahun.required' => 'The tanggal akhir field is required.',
            'total_potongan.required' => 'The nominal field is required.',
            'total_potongan.required' => 'Select the type.',
            'kode_voucher.unique' => 'The kode voucher has already been taken.'
        ];
    }
}
