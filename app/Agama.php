<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agama extends Model
{
    
    public $table = 'agamas';
   


    public static function getAgama($value)
    {
        return Agama::where('id', $value)->select('nama')->first();
    }
}
