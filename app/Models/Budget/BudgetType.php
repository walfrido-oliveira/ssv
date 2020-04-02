<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Model;

class BudgetType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
