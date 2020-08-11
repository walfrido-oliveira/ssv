<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Billing\Billing;
use App\Http\Controllers\Controller;

class BillingController extends Controller
{
    /**
	 * @var Billing
	 */
    private $billing;

    /**
     * create a new instance of controll
     *
     * @param Billing $billing
     */
	public function __construct(Billing $billing)
	{
        $this->billing = $billing;

        $this->middleware('permission:billing-list', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = User::getClientsId();
        $billings = $this->billing->whereIn('client_id', $clients)->paginate(10);

        return view('user.billings.index', compact('billings'));
    }
}