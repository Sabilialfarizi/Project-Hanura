<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MstSupplier extends BaseModel
{
    use SoftDeletes;
    public $table = 'mst_supplier';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'nama',
        'no_telp',
        'no_hp',
        'email',
        'pic',
        'no_rekening',
        'ppn',
        'alamat',
        'password',
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

    public const YesPpn = 1;
    public const NoPpn  = 0;
}
