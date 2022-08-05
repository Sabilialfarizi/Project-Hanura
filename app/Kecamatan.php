<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Kabupaten;

class Kecamatan extends Model
{
    use softDeletes;
    public $table = 'kecamatans';
    protected $fillable = ['id_kab', 'name', 'id_kec'];

    public static function getKec($value)
    {
        return Kecamatan::where('id_kec', $value)->select('name')->first();
    }
    
    public function Kabupaten()
    {
        return $this->HasOne(Kabupaten::class, 'id_kab', 'id_kab');
    }
}