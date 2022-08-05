<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemUnit extends BaseModel
{
    use SoftDeletes;
    public $table = 'unit_barang';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'nama',
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

    public static function getName($value)
    {
        return ItemUnit::where('id', $value)->select('nama')->first();
    }
}
