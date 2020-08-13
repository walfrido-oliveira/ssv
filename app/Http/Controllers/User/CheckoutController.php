<?php

namespace App\Http\Controllers\User;

use MercadoPago\SDK;
use MercadoPago\Payment;
use Illuminate\Http\Request;
use App\Models\Billing\Billing;
use App\Models\TransactionPayment;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    /**
     * Show checkout view
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!auth()->check()) return redirect()->route('login');

        $billing = Billing::find($id);

        if($billing->status == 'paid') return redirect()->route('user.billings.show', ['billing' => $billing->id]);

        $docType = strlen($billing->client->client_id) > 11 ? 'CNPJ' : 'CPF';
        $docNumber = $billing->client->client_id;

        $this->setAcess();

        $docTypesTemp = SDK::get('/v1/identification_types');

        if (is_array($docTypesTemp)) {
            if ($docTypesTemp['code'] == 200) {
                foreach ($docTypesTemp['body'] as $key => $value) {
                    $docTypes[$value['id']] = $value['name'];
                }
            }
        }

        return view('user.checkout', compact('billing', 'docTypes', 'docType', 'docNumber'));
    }

    /**
     * Process payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function proccess(Request $request)
    {
        $this->setAcess();

        $data = $request->all();

        $billing = Billing::find($data['billing_id']);

        $amount = str_replace('R$ ', '', $data['transaction_amount'], );
        $amount = str_replace('.', '', $amount);
        $amount = str_replace(',', '.', $amount);

        $payment = new Payment();

        $payment->token = $data['token'];
        $payment->installments = $data['installments'];
        $payment->transaction_amount = (float)$amount;
        $payment->description = $data['description'];
        $payment->payment_method_id = $data['payment_method_id'];
        $payment->payer =
        [
            'email' => $billing->budget->clientContact->email,
            'identification' => [
                'number' => $billing->client->client_id,
                'type' => strlen($billing->client->client_id) > 11 ? 'CNPJ' : 'CPF'
            ]
        ];

        //$payment->notification_url = route('notifications');

        if (!$payment->save()) {
            flash('error', __($payment->error->message));
            return redirect()->route('user.checkout.show', ['billing' => $billing->id]);
        } else {
            TransactionPayment::create([
                'billing_id' => $billing->id,
                'payment_id' => $payment->id
            ]);

            $this->setPaymentNotification($payment, $billing);
        }

        $response = $this->setResponse($payment);

        flash($response['status'], $response['message']);

        return redirect()->route('user.billings.show', ['billing' => $billing->id]);
    }

    /**
     * Set payment notification to a user
     *
     * @param  Payment $payment
     * @param  Billing $billing
     */
    private function setPaymentNotification($payment, $billing)
    {
        if ($payment->status == 'approved' && $payment->status_detail == 'accredited') {
            $billing->status = 'paid';
            $billing->save();
            $billing->sendApprovedPayment();
        } else if ($payment->status == 'in_process') {
            $billing->status = 'in_process';
            $billing->save();
            $billing->sendInProcessdPayment();
        } else if ($payment->status == 'rejected') {
            $billing->status = 'pending';
            $billing->save();
            $billing->sendDisapprovedPayment();
        }
    }

    /**
     * Set mercadopago response SDK
     */
    private function setResponse($payment)
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

    /**
     * Set mercadopago SDK
     */
    private function setAcess()
    {
        SDK::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
    }
}
