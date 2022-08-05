<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TransaksiStok extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'nama',
        'nomor_transaksi',
        'nomor_ijin',
        'gudang_id',
        'rak_id',
        'tanggal_transaksi',
        'tipe',
        'is_active',
        'created_by',
        'deleted_by',
        'updated_by',
    ];

    public const Active = 1;
    public const NotActive = 0;
    public const TypeStatus = [
        0 => 'Not Active',
        1 => 'Active'
    ]; 

    public const TypeTransaction = [
        1 => 'IN',
        2 => 'OUT'
    ]; 

    public function getGudang() 
    {
        return $this->belongsTo(\App\MstGudang::class,'gudang_id');
    }

    public function getDetail()
    {
        return $this->hasMany(\App\TransaksiStokDetail::class,'transaksi_id','id');
    }
}
