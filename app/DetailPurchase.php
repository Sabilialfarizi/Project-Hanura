<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPurchase extends Model
{
    public $table = 'r_detail_purchases';

    public static function countPO($id)
    {
        return DetailPurchase::where('no_po',$id)->count();
    }
}
