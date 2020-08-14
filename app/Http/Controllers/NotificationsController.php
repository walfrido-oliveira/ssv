<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PaymentNotification;

class NotificationsController extends Controller
{

    /**
     * Get notification from payments
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentNotification(Request $request)
    {
        $data = $request->all();

        PaymentNotification::create([
            'topic' => $data['topic'],
            'payment_id' => $data['id']
        ]);

        return response();
    }
}
