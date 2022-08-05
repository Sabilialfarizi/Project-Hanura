<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mst_lokasi extends Model
{
    // use HasFactory;
    protected $table    = 'lokasi';

    protected $fillable     =   [ 
                            'latitude','longitude','nama','alamat'
        ]; 
}
