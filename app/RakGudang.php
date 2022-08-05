<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class RakGudang extends Model
{
    use SoftDeletes;
    public $table = 'rak_gudangs';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'gudang_id',
        'name',
        'created_by',
        'deleted_by',
        'updated_by',
    ];

    public static function getName($value)
    {
        return RakGudang::where('id', $value)->select('name')->first();
    }
}
