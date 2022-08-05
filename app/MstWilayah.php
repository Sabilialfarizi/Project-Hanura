<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MstWilayah extends Model
{
    use SoftDeletes;
    public $table = 'mst_wilayahs';
}
