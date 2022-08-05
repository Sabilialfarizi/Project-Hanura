<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    public $table = 'status_pernikahans';
    
    public static function getNikah($value)
    {
        return MaritalStatus::where('id', $value)->select('nama')->first();
    }
}
