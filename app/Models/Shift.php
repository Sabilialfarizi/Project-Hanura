<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['kode', 'waktu_mulai', 'waktu_selesai'];
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
