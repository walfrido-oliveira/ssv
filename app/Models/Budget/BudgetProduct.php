<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Model;

class BudgetProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'index'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'integer',
        'index' => 'integer',
    ];
}
