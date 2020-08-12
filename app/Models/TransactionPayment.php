<?php

namespace App\Models;

use MercadoPago\SDK;
use MercadoPago\Payment;
use Illuminate\Database\Eloquent\Model;

class TransactionPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'billing_id', 'payment_id'
    ];

    /**
     * Get payment
     */
    public function getPaymentAttribute()
    {
        SDK::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        $payment = new Payment();
        return $payment->get(28849682);
    }
}
