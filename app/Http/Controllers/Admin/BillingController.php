<?php

namespace App\Http\Controllers\Admin;

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

        $this->middleware('permission:billing-list', ['only' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = User::getClientsId();
        $billings = $this->billing->paginate(10);

        return view('admin.billings.index', compact('billings'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$this->billing->checkClient($id)) abort(404);

        $billing = $this->billing->find($id);

        return view('admin.billings.show', compact('billing'));
    }
}
