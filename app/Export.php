<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Export extends Model
{

    public $table = 'kta_ktp_exports';
    public $timestamps = false;
    protected $keyType = 'string';

    public function Districts(){
        return $this->belongsTo(Kecamatan::class, 'district_id', 'id_kec');
    }
}
