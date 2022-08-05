<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodeProgram extends Model
{
    use SoftDeletes;
    public $table = 'periode_programs';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'description',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'is_active',
        'deleted_at'
    ];
}
