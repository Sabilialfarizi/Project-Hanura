<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kantor extends Model
{
    use softDeletes;

    protected $table = 'kantor';

    protected $fillable = [
        'alamat',
        'id_daerah',
        'id_tipe_daerah',
        'provinsi',
        'kab_kota',
        'kec',
        'kel',
        'rt_rw',
        'no_telp',
        'email',
        'fax',
        'is_active',
    ];

    public function getProvinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi', 'id_prov');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kab_kota', 'id_kab');
    }
    
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kec', 'id_kec');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kel', 'id_kel');
    }
}