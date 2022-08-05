<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiStokDetail extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'id',
        'transaksi_id',
        'barang_id',
        'qty',
        'nomor_sparepart',
    ];
}
