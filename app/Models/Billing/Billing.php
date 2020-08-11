<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'budget_id', 'client_id', 'payment_method_id', 'due_date',
        'created_at', 'amount', 'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'datetime',
        'created_at' => 'datetime',
    ];
}
