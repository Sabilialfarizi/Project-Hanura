<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRequest extends Model
{
    use SoftDeletes;
    public $table = 'r_detail_requests';
    
    protected $fillable = [
        'id',
        'no_req',
        'receiver_id',
        'created_at',
        'updated_at',
        'status_penerima',
        'tanggal_terima',
        'deleted_at',
    ];

    public static function countRO($id)
    {
        return DetailRequest::where('no_req',$id)->count();
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user              = \Auth::user();
            $status_penerima   = 1;
            $model->created_by = $user->id ?? '9999';
            $model->updated_by = $user->id ?? '9999';
        });
        static::updating(function ($model) {
            $user              = \Auth::user();
            $model->updated_by = $user->id ?? '9999';
        });
        static::deleting(function ($model) {
            $model->deleted_at = date('Y-m-d H:i:s');
        });
    }
}
