<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPacket extends Model
{
    use SoftDeletes;
    public $table = 'b_detail_packets';

    protected $fillable = [
        'id',
        'id_barang',
        'kode_barang',
        'qty',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    // public static function countPrograms($id)
    // {
    //     return DetailPeriodeProgram::where('id_periode',$id)->count();
    // }
}
