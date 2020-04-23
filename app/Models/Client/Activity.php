<?php

namespace App\Models\Client;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'created_at', 'updated_at',
    ];

}
