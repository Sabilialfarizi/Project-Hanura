<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    
    public $table = 'bank';
   
    protected $fillable = [
        'id_bank',
        'nama_bank',
        'is_active',
        'status',
     
     
    ];
    public $timestamps = false;
    public static function getbank($value)
    {
        return Bank::where('id_bank', $value)->select('nama_bank')->first();
    }
}
