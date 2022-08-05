<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
      public $table = 'jabatans';
   


    public static function getJabatan($value)
    {
        return Jabatan::where('kode', $value)->select('nama')->first();
    }
}