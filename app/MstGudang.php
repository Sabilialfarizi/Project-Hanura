<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MstGudang extends BaseModel
{
    use SoftDeletes;
    public $table = 'mst_gudang';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'nama_gudang',
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

    public static function getWarehouse($value)
    {
        return MstGudang::where('id', $value)->select('nama_gudang')->first();
    }
}
