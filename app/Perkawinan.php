<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perkawinan extends Model
{
   
    public $table = 'status_pernikahans';
     public $timestamps = false;
    
       public static function getMer($value)
    {
        return Perkawinan::where('id', $value)->select('nama')->first();
    }
}
