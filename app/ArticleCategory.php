<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    
    public $table = 'article_categories';
   
    protected $fillable = [
        'id',
        'name',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public static function getCategory($value)
    {
        return ArticleCategory::where('id', $value)->select('name')->first();
    }
}
