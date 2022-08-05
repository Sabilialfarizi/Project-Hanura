<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    public $table = 'members';
   
    protected $fillable = [
        'id',
        'nama',
        'nik',
        'no_telp' ,
        'no_hp' ,
        'email' ,
        'password' ,
        'alamat' ,
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'gender',
        'foto_ktp' ,
        'foto_kk' ,
        'status_kawin',
        'no_member',
        'pekerjaan',
        'status_korlap',
        'is_active',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
        'is_verify'
    ];

    public const Active = 1;
    public const NotActive = 0;
    public const TypeStatus = [
        0 => 'Not Active',
        1 => 'Active'
    ];
    
    public const typeVerif = [
        0 => 'Unverify',
        1 => 'Verified'
    ];
    
}
