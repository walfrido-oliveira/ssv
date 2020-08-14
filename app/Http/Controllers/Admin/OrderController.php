<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use App\Models\Order\OrderService;
use App\Http\Controllers\Controller;
use App\Models\Budget\BudgetService;

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
        $userId = auth()->user()->id;
        $data = $request->all();

        $data['user_id'] = $userId;
        $data['client_id'] = Budget::find($data['budget_id'])->client->id;

        $order = $this->order->create($data);

        if (isset($data['services']))
        {
            foreach ($data['services'] as $key => $service) {
                $service['service_id'] =  BudgetService::find($service['budget_service_id'])->service->id;
                $service['user_id'] = $userId;
                $service['order_id'] = $order->id;

                $service = OrderService::create($service);
            }
        }

        $order->sendCreatedOrder();

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
        $order = $this->order->find($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $clients = Client::where('id', $order->client_id)->get()->pluck('nome_fantasia', 'id');
        $budgets = Budget::where('id', $order->budget_id)->get()->pluck('name', 'id');

        return view('admin.orders.edit', compact('order', 'clients', 'budgets'));
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
        $request->validate($this->roles($this->order));
        $userId = auth()->user()->id;
        $order = $this->order->find($id);

        $data = $request->all();
        $data['user_id'] = $userId;

        $order->update($data);

        $servicesIds = $order->services->pluck('id');

        if (!isset($data['services'])) $data['services'] = [];

        foreach ($servicesIds as $key => $id)
        {
            if(array_search($id, array_column($data['services'], 'id')) === false)
            {
                $service = OrderService::find($id);
                $service->delete();
            }
        }

        foreach ($data['services'] as $key => $service)
        {

            $service['service_id'] = BudgetService::find($service['budget_service_id'])->service->id;

            if(isset($service['id']))
            {
                $orderService = OrderService::find($service['id']);

                if(!is_null($orderService))
                {
                    $orderService->update($service);
                }
            } else {
                $service['user_id'] = $userId;
                $service['order_id'] = $order->id;
                $service = OrderService::create($service);
            }
        }

        flash('success', 'Order updated successfully!');

        return redirect()->route('admin.orders.index');
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
