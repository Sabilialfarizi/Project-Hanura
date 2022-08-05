<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penghubung extends Model
{   
    use SoftDeletes;
    protected $table = 'petugas_penghubung';
    protected $guarded = ['id'];
    // public $timestamps = false;
}
