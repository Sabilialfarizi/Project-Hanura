<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
  

    public $table = 'information';

    protected $fillable = [
        'id',
        'kategori_id',
        'name',
        'content' ,
        'gambar' ,
        'is_active' ,
        'created_by' ,
        'updated_by' ,
        'created_at',
        'updated_at'
    ];

    public function getUser(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getCategory(){
        return $this->belongsTo(ArticleCategory::class, 'kategori_id');
    }
}