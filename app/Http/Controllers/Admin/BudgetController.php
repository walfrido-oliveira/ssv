<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use App\Models\Budget\BudgetType;
use App\Http\Controllers\Controller;
use App\Models\Budget\PaymentMethod;
use App\Models\Budget\TransportMethod;
use App\Models\Client\Contact\ClientContact;

class BudgetController extends Controller
{
    /**
	 * @var Budget
	 */
    private $budget;

    /**
     * create a new instance of controll
     */
	public function __construct(Budget $budget)
	{
        $this->budget = $budget;

        $this->middleware('permission:budget-list|budget-create|budget-edit|budget-delete', ['only' => ['index','store']]);
        $this->middleware('permission:budget-create', ['only' => ['create','store']]);
        $this->middleware('permission:budget-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:budget-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budgets = $this->budget->paginate(10);
        return view('admin.budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $budgetTypes = BudgetType::all()->pluck('name', 'id');
        $paymentMethods = PaymentMethod::all()->pluck('name', 'id');
        $transportMethods = TransportMethod::all()->pluck('name', 'id');

        return view('admin.budgets.create', compact('budgetTypes', 'paymentMethods', 'transportMethods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->budget));

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        $services = [];
        $products = [];

        if (isset($data['services']))
        {
            $servicesTemp = $data['services'];
            $services = array_map(function($line) {
                return
                [
                "service_id" => $line['service_id'],
                "amount" => $line['amount']
                ];
            }, $servicesTemp);
        }

        if (isset($data['products']))
        {
            $productsTemp = $data['products'];
            $products = array_map(function($line) {
                return
                [
                "product_id" => $line['product_id'],
                "amount" => $line['amount']
                ];
            }, $productsTemp);
        }

        $budget = $this->budget->create($data);

        $budget->services()->sync($services);
        $budget->products()->sync($products);

        flash('success', 'Budget added successfully!');

        return redirect()->route('admin.budgets.index');
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
        $budget = Budget::Find($id);
        $clients = Client::where('id', $budget->client_id)->get()->pluck('nome_fantasia', 'id');
        $contacts = ClientContact::where('id', $budget->client_contact_id)->get()->pluck('full_description', 'id');
        $budgetTypes = BudgetType::all()->pluck('name', 'id');
        $paymentMethods = PaymentMethod::all()->pluck('name', 'id');
        $transportMethods = TransportMethod::all()->pluck('name', 'id');

        return view('admin.budgets.edit',
        compact('budgetTypes', 'paymentMethods', 'transportMethods', 'budget', 'clients', 'contacts'));
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
        $request->validate($this->roles($this->budget));

        $budget = $this->budget->find($id);

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        $services = [];
        $products = [];

        if (isset($data['services']))
        {
            $servicesTemp = $data['services'];
            $services = array_map(function($line) {
                return
                [
                "service_id" => $line['service_id'],
                "amount" => $line['amount']
                ];
            }, $servicesTemp);
        }

        if (isset($data['products']))
        {
            $productsTemp = $data['products'];
            $products = array_map(function($line) {
                return
                [
                "product_id" => $line['product_id'],
                "amount" => $line['amount']
                ];
            }, $productsTemp);
        }

        $budget->update($data);

        $budget->services()->sync([]);
        $budget->services()->sync($services);
        $budget->products()->sync([]);
        $budget->products()->sync($products);

        flash('success', 'Budget updated successfully!');

        return redirect()->route('admin.budgets.index');
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
     * @param Budget $budget
     * @return array
     */
    public function roles($budget)
    {
        return
        [
            'budget_type_id' => 'required',
            'payment_method_id' => 'required',
            'transport_method_id' => 'required',
            'client_contact_id' => 'required',
            'client_id' => 'required',
            'validity' => 'required',
        ];
    }
}
