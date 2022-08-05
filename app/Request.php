<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use SoftDeletes;
    public $table =  'requests';

    protected $fillable = [
        'no_request',
        'program_id',
        'created_by',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
