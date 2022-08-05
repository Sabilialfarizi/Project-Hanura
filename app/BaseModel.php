<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class BaseModel extends \Illuminate\Database\Eloquent\Model
{
    
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user              = Auth::user();
            $model->created_by = $user->id ?? '9999';
            $model->updated_by = $user->id ?? '9999';
        });
        static::updating(function ($model) {
            $user              = Auth::user();
            $model->updated_by = $user->id ?? '9999';
        });
        static::deleting(function ($model) {
            $user              = Auth::user();
            $model->deleted_by = $user->id ?? '9999';
        });
    }
}
