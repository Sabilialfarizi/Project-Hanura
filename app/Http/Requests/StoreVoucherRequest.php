<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
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
            // 'kode_voucher' => 'required|unique:vouchers',
            'tgl_mulai' => 'required',
            'tgl_akhir' => 'required',
            'min_transaksi' => 'required',
            'nominal' => 'required',
            'type' => 'required',
            'persentase' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'tgl_mulai.required' => 'The tanggal mulai field is required.',
            'tgk_akhir.required' => 'The tanggal akhir field is required.',
            'min_transaksi.required' => 'The min transaksi field is required.',
            'nominal.required' => 'The nominal field is required.',
            'type.required' => 'Select the type.',
            'persentase.required' => 'The Percentage field is required.',
            // 'kode_voucher.unique' => 'The kode voucher has already been taken.'
            // 'kode_voucher.required' => 'The kode voucher field is required.',
        ];
    }
}
