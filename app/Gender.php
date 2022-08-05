<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gender extends Model
{
    
    public $table = 'jenis_kelamin';
   
    protected $fillable = [
        'id',
        'name',
        'key_gender',
       
    ];
    public $timestamps = false;

    public static function getGender($value)
    {
        return Gender::where('id', $value)->select('name')->first();
    }
}
