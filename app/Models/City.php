<?php

namespace App\Models;

use App\Models\Uf;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uf', 'name'
    ];

    /**
     * return a single Uf
     *
     * @return Uf
     */
    public function uf()
    {
        return $this->belongsTo(Uf::class);
    }
}
