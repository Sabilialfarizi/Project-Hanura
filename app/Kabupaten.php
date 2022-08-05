<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Provinsi;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kabupaten extends Model
{
    use SoftDeletes;
    public $table = 'kabupatens';
    protected $fillable = ['id_prov', 'id_kab','name','id_wilayah'];

    public static function getKab($value)
    {
        return Kabupaten::where('id_kab', $value)->select('name','id_prov')->first();
    }

    public function provinsi(){
        return $this->belongsTo(Provinsi::class);
    }
    
    public function Provins()
    {
        return $this->HasOne(Provinsi::class, 'id_prov', 'id_prov');
    }
}