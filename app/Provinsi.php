<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provinsi extends Model
{
    use SoftDeletes;
    public $table = 'provinsis';
    protected $fillable = ['id','id_prov','name','delete_at','created_at','updated_at','status','alamat_kantor','rt_rw','kelurahan','kecamatan','kota_kabupaten','nomor_telepon','alamat_email','sosial_media','id_ketua_dpd','id_sekre_dpd','id_benda_dpd','zona_waktu'];
    
    public static function getProv($value)
    {
        return Provinsi::where('id_prov', $value)->select('name')->first();
    }
    public function kabupaten(){
        return $this->hasMany(Kabupaten::class);
    }
}
