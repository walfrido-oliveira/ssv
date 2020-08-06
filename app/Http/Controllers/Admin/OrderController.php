<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
	 * @var Order
	 */
    private $order;

    /**
     * create a new instance of controll
     *
     * @param Order $order
     */
	public function __construct(Order $order)
	{
        $this->order = $order;

        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','store']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->order->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$budgetTypes = BudgetType::all()->pluck('name', 'id');
       // $paymentMethods = PaymentMethod::all()->pluck('name', 'id');
        //$transportMethods = TransportMethod::all()->pluck('name', 'id');

        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->order));

        $data = $request->all();

        $data['user_id'] = auth()->user()->id;
        $data['client_id'] = Budget::find($data['budget_id'])->client->id;

        $order = $this->order->create($data);

        //$order->notify(new CreateOrder($order));

        flash('success', 'Order added successfully!');

        return redirect()->route('admin.orders.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get rules of validation
     *
     * @param Order $order
     * @return array
     */
    public function roles($order)
    {
        return
        [
            'budget_id' => 'required|exists:budgets,id',
        ];
    }
}