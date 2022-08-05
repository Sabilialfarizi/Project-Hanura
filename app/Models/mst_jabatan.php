<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_jabatan extends Model
{
    // use HasFactory;
     //
     protected $table    = 'jabatan';

     protected $fillable     =   [ 
                             'jabatan'
         ]; 
 
         public function scopeSelectBox($query)
         {
           $return = array();
           $data   = $query->orderBy('jabatan')->get()->toArray();
           foreach ($data as $key => $value) {
           $return[$value['id']] = $value['jabatan'];
         }
           return $return;
         }
}
