<?php

namespace App\Models\Billing;

use App\Models\User;
use MercadoPago\Payment;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use App\Models\TransactionPayment;
use App\Notifications\ApprovedPayment;
use App\Notifications\InProcessPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\DisapprovedPayment;

class Billing extends Model
{

    use Notifiable;

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

    /**
     * Get formatted id
     */
    public function getFormattedIdAttribute()
    {
        return sprintf("%05d", $this->id);
    }

    /**
     * return a single Client
     *
     * @return Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * return a single TransactionPayment
     *
     * @return TransactionPayment
     */
    public function transactionPayments()
    {
        return $this->hasMany(TransactionPayment::class);
    }

    /**
     * return a single Budget
     *
     * @return Budget
     */
    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * Check if client user has acess to budget
     *
     * @param  int  $id
     *
     * @return boolean
     */
    public function checkClient($id)
    {
        $clients = User::getClientsId();

        $billings = $this->whereIn('client_id', $clients)->where('id', $id)->first();

        return !is_null($billings);

    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        return [$this->budget->clientContact->email => $this->budget->clientContact->name];
    }

    public function sendApprovedPayment()
    {
        $this->notify(new ApprovedPayment($this));
    }

    public function sendDisapprovedPayment()
    {
        $this->notify(new DisapprovedPayment($this));
    }

    public function sendInProcessdPayment()
    {
        $this->notify(new InProcessPayment($this));
    }

    /**
     * Send payment notification to a user
     *
     * @param Payment $payment
     */
    private function sendPaymentNotification($payment)
    {
        if ($payment->status == 'approved' && $payment->status_detail == 'accredited') {
            $this->status = 'paid';
            $this->save();
            $this->sendApprovedPayment();
        } else if ($payment->status == 'in_process') {
            $this->status = 'in_process';
            $this->save();
            $this->sendInProcessdPayment();
        } else if ($payment->status == 'rejected') {
            $this->status = 'pending';
            $this->save();
            $this->sendDisapprovedPayment();
        }
    }

    /**
     * Get mercadopago response
     *
     * @param Payment $payment
     */
    private function getPaymentResponse($payment)
    {
        if ($payment->status == 'approved' && $payment->status_detail == 'accredited') {
            return
            [
                "status" => "success",
                "message" => __('There, your payment has been approved! In the summary, you will see the charge for the amount as :statement_descriptor. We are processing the payment.', ['statement_descriptor' => $payment->statement_descriptor])
            ];
        }
        if ($payment->status == 'in_process' && $payment->status_detail == 'pending_contingency') {
            return
            [
                "status" => "info",
                "message" => __('Dont worry, less than 2 working days we will inform you by email if you have been credited. We are processing you you payment.')
            ];
        }
        if ($payment->status == 'in_process' && $payment->status_detail == 'pending_review_manual') {
            return
            [
                "status" => "info",
                "message" => __('Dont worry, less than 2 working days we will inform you by email if you have been credited or if we need mode information. We are processing you you payment.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_bad_filled_card_number') {
            return
            [
                "status" => "error",
                "message" => __('Review the card number.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_bad_filled_date') {
            return
            [
                "status" => "error",
                "message" => __('Review the expiration date.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_bad_filled_other') {
            return
            [
                "status" => "error",
                "message" => __('Review the data.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_bad_filled_security_code') {
            return
            [
                "status" => "error",
                "message" => __('Review the cards security code.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_blacklist') {
            return
            [
                "status" => "error",
                "message" => __('We were unable to process your payment.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_call_for_authorize') {
            return
            [
                "status" => "error",
                "message" => __('You must authorize :payment_method_id to pay the amount to Mercado Pago', ['payment_method_id' => $payment->payment_method_id])
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_card_disabled') {
            return
            [
                "status" => "error",
                "message" => __('Call :payment_method_id  to activw your card. The phone is on the back of your card.', ['payment_method_id' => $payment->payment_method_id])
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_card_error') {
            return
            [
                "status" => "error",
                "message" => __('We were unable to process your payment')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_duplicated_payment') {
            return
            [
                "status" => "error",
                "message" => __('You have already made a payment for this amount. If you need to pay again, use another card or another form of payment. Your payment was declined.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_high_risk') {
            return
            [
                "status" => "error",
                "message" => __('Choose another form of payment. We recommend cash payment methods.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_insufficient_amount') {
            return
            [
                "status" => "error",
                "message" => __(':payment_method_id does not have an insufficient balance.', ['payment_method_id' => $payment->payment_method_id])
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_invalid_installments') {
            return
            [
                "status" => "error",
                "message" => __(':payment_method_id does not process payments on installments installments.', ['payment_method_id' => $payment->payment_method_id])
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_max_attempts') {
            return
            [
                "status" => "error",
                "message" => __('You have reached the allowed retry limit.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_other_reason') {
            return
            [
                "status" => "error",
                "message" => __('Choose another card or payment method.')
            ];
        }
        if ($payment->status == 'rejected' && $payment->status_detail == 'cc_rejected_bad_filled_card_number') {
            return
            [
                "status" => "error",
                "message" => __(':payment_method_id does not process the payment.', ['payment_method_id' => $payment->payment_method_id])
            ];
        }

    }
}
