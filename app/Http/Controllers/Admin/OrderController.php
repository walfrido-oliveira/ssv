<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use App\Models\Order\OrderProduct;
use App\Models\Order\OrderService;
use App\Http\Controllers\Controller;
use App\Models\Budget\BudgetProduct;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = trim($request->q);

        if (empty($term) && !$request->has('status')) {
            $orders = $this->order
            ->paginate(10);
        } else if($request->has('status')) {
            $orders = $this->order->where('status', '=', $request->status)
            ->paginate(10);
        } else {
            $orders = $this->order
            ->whereHas('client', function($query) use ($term) {
                    $query->where('clients.razao_social', 'like', '%' . $term . '%');
            })->orwhere('id', '=', $term)
            ->paginate(10);
        }

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

        if (isset($data['products']))
        {
            foreach ($data['products'] as $key => $product) {
                $product['product_id'] =  BudgetProduct::find($product['budget_product_id'])->product->id;
                $product['user_id'] = $userId;
                $product['order_id'] = $order->id;

                $product = OrderProduct::create($product);
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
        $productsIds = $order->products->pluck('id');

        if (!isset($data['services'])) $data['services'] = [];
        if (!isset($data['products'])) $data['products'] = [];

        foreach ($servicesIds as $key => $id)
        {
            if(array_search($id, array_column($data['services'], 'id')) === false)
            {
                $service = OrderService::find($id);
                $service->delete();
            }
        }

        foreach ($productsIds as $key => $id)
        {
            if(array_search($id, array_column($data['products'], 'id')) === false)
            {
                $product = OrderProduct::find($id);
                $product->delete();
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
                $service['service_id'] =  BudgetService::find($service['budget_service_id'])->service->id;
                $service = OrderService::create($service);
            }
        }

        foreach ($data['products'] as $key => $product)
        {

            $product['product_id'] = BudgetProduct::find($product['budget_product_id'])->product->id;

            if(isset($product['id']))
            {
                $orderProduct = OrderProduct::find($product['id']);

                if(!is_null($orderProduct))
                {
                    $orderProduct->update($product);
                }
            } else {
                $product['user_id'] = $userId;
                $product['order_id'] = $order->id;
                $product['product_id'] =  BudgetProduct::find($product['budget_product_id'])->product->id;
                $product = OrderProduct::create($product);
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
