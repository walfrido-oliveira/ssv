<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uf', 'name'
    ];
}
