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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = User::getClientsId();

        $term = trim($request->q);

        if (empty($term) && !$request->has('status')) {
            $billings = $this->billing
            ->paginate(10);
        } else if($request->has('status')) {
            $billings = $this->billing->where('status', '=', $request->status)
            ->paginate(10);
        } else {
            $billings = $this->billing
            ->whereHas('client', function($query) use ($term) {
                    $query->where('clients.razao_social', 'like', '%' . $term . '%');
            })->orwhere('id', '=', $term)
            ->orwhere('amount', '=', is_numeric($term) ? $term : true)
            ->orwhere('due_date', 'like', is_date($term) ? date_format(date_create_from_format('d/m/Y', $term), 'Y-m-d') . '%' : '')
            ->orwhere('created_at', 'like', is_date($term) ? date_format(date_create_from_format('d/m/Y', $term), 'Y-m-d') . '%' : '')
            ->paginate(10);
        }

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
        $billing = $this->billing->find($id);

        return view('admin.billings.show', compact('billing'));
    }
}
