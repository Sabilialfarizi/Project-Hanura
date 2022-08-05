<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'kode_voucher' => Rule::unique('vouchers')->ignore($this->voucher),
            'tgl_mulai' => 'required',
            'tgl_akhir' => 'required',
            'min_transaksi' => 'required',
            'nominal' => 'required',
            'type' => 'required',
            'persentase' => 'required',
            'kuota' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'kode_voucher.required' => 'The kode voucher field is required.',
            'tgl_mulai.required' => 'The tanggal mulai field is required.',
            'tgk_akhir.required' => 'The tanggal akhir field is required.',
            'min_transaksi.required' => 'The min transaksi field is required.',
            'nominal.required' => 'The nominal field is required.',
            'type.required' => 'Select the type.',
            'persentase.required' => 'The persentase field is required.',
            'kuota.required' => 'The kuota field is required.',
            'kode_voucher.unique' => 'The kode voucher has already been taken.'
        ];
    }
}
