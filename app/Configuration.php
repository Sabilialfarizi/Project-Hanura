<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'name',
        'value',
        'is_file'
    ];

    public const File = 1;
    public const Text = 0;
}
