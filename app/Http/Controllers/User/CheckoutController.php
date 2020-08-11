<?php

namespace App\Http\Controllers\User;

use MercadoPago\SDK;
use MercadoPago\Payment;
use Illuminate\Http\Request;
use App\Models\Billing\Billing;
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

        $this->setAcess();

        $docTypesTemp = SDK::get('/v1/identification_types');

        if (is_array($docTypesTemp)) {
            if ($docTypesTemp['code'] == 200) {
                foreach ($docTypesTemp['body'] as $key => $value) {
                    $docTypes[$value['id']] = $value['name'];
                }
            }
        }

        return view('user.checkout', compact('billing', 'docTypes'));
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

        $amount = str_replace('R$ ', '', $data['transaction_amount'], );
        $amount = str_replace('.', '', $amount);
        $amount = str_replace(',', '.', $amount);

        $payment = new Payment();
        $payment->transaction_amount = (float)$amount;
        $payment->token = $data['token'];
        $payment->description = $data['description'];
        $payment->installments = $data['installments'];
        $payment->payment_method_id = $data['payment_method_id'];
        $payment->payer = array(
        "email" => $data['email']
        );

        $payment->save();

        $response = $this->setResponse($payment);

        flash($response['status'], $response['message']);

        return redirect()->route('user.billings.show', ['billing' => 1]);
    }

    /**
     * Set mercadopago response SDK
     */
    private function setResponse($payment)
    {
        switch ($payment->status) {
            case 'approved':
                return
                [
                    "status" => "success",
                    "message" => "Pronto, seu pagamento foi aprovado! No resumo, você verá a cobrança do valor como $payment->statement_descriptor. Estamos processando o pagamento."
                ];
                break;
        }

    }

    /**
     * Set mercadopago SDK
     */
    private function setAcess()
    {
        SDK::setAccessToken(config('app.mercadopago.ACCESS_TOKEN'));
    }
}
