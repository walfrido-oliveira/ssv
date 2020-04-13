<?php

namespace App\Models;

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

    public function getFullNameAttribute()
    {
        return $this->uf . ' - ' . $this->name;
    }
}
