<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id', 'topic'
    ];
}
