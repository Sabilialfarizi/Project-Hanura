<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelurahan extends Model
{
    use SoftDeletes;
    public $table = 'kelurahans';
    protected $fillable = [
        'id_kec',
        'id_kel',
        'name',
        'id_wilayah',
    ];

    public static function getKel($value)
    {
        return Kelurahan::where('id_kel', $value)->select('name')->first();
    }
}