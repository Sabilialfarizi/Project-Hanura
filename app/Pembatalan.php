<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembatalan extends Model
{
    protected $guarded = ['id'];
    protected $table = 'pembatalan_anggota';
    public $timestamps = false;
}
