<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailUsers extends Model
{
    // use SoftDeletes;

    public $table = 'detail_users';
    protected $guarded = [];
	
   

    public const Active = 1;
    public const NotActive = 0;
    public const TypeStatus = [
        0 => 'Not Active',
        1 => 'Active'
    ];
    
    public const typeVerif = [
        0 => 'Unverify',
        1 => 'Verified'
    ];

    public static function getName($value)
    {
        return DetailUsers::where('userid', $value)->select('nickname')->first();
    }
     public static function getDetail($value)
    {
        return DetailUsers::where('id', $value)->select('nickname')->first();
    }

    public function kabupaten(){
        return $this->belongTo(Kabupaten::class,'kabupaten_domisili');
    }

    public function provinsi(){
        return $this->belongTo(Provinsi::class,'provinsi_domisili');
    }

}
