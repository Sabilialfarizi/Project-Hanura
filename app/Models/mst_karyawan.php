<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_karyawan extends Model
{
    // use HasFactory;
    protected $table    = 'karyawan';

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'karyawan_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Roles::class);
    }
}
