<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    public $table = 'stok_barang';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'gudang_id',
        'id',
        'barang_id',
        'stock',
    ];
}
