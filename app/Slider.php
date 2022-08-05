<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    //
    use SoftDeletes;

    public $table =  'sliders';
    protected $fillable = [
        'name',
        'isi',
        'status',
        'gambar',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user              = \Auth::user();
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
