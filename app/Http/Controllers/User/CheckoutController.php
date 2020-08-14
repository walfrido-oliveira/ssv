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

            $billing->setPaymentNotification($payment, $billing);
        }

        $response = $billing->getPaymentResponse($payment);

        flash($response['status'], $response['message']);

        return redirect()->route('user.billings.show', ['billing' => $billing->id]);
    }

    /**
     * Set mercadopago accesss
     */
    private function setAcess()
    {
        SDK::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
    }
}
