<?php

namespace App\Models\Budget;

use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Model;

class BudgetService extends Model
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
