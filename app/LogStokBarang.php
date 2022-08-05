<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogStokBarang extends Model
{
    public $table = 'log_stok_barang';
    // public $timestamps = false;
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    protected $fillable = [
        'stock_barang_id',
        'id',
        'log_type',
        'transaksi_id',
        'qty_before',
        'qty_after',
        'created_by'
    ];

    public const BarangMasuk = 100;
    public const BarangKeluar = 200;
}
