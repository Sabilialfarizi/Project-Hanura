<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kepengurusan extends Model
{
    use softDeletes;

    protected $table = 'kepengurusan';
    protected $primaryKey = 'id_kepengurusan';

    protected $fillable = [
        'id_daerah',
        'jabatan',
        'nama',
        'kta',
        'nik',
        'no_sk',
        'alamat_kantor',
        'foto',
        'ttd'
    ];

    public function getJabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan', 'kode');
    }

}