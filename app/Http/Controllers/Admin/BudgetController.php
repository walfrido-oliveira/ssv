<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Client\Client;
use App\Models\Service\Service;
use App\Models\Budget\BudgetType;
use Illuminate\Support\Facades\DB;
use App\Notifications\CreateBudget;
use App\Http\Controllers\Controller;
use App\Models\Budget\BudgetService;
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
     *
     * @param Budget $budget
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = trim($request->q);

        if (empty($term) && !$request->has('status')) {
            $budgets = $this->budget->paginate(10);
        } else if($request->has('status')) {
            $budgets = $this->budget->where('status', '=', $request->status)->paginate(10);;
        } else {
            $budgets = $this->budget->whereHas('client', function($query) use ($term) {
                $query->where('clients.razao_social', 'like', '%' . $term . '%');
            })->orwhere('id', '=', $term)
            ->orwhere('amount', '=', is_numeric($term) ? $term : true)
            ->paginate(10);
        }
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
                    "amount" => $line['amount'],
                    "index" => $line['index']
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
                    "amount" => $line['amount'],
                    "index" => $line['index']
                ];
            }, $productsTemp);
        }

        $budget = $this->budget->create($data);

        $budget->services()->sync($services);
        $budget->products()->sync($products);

        $budget->amount = $budget->productAmount + $budget->serviceAmount;
        $budget->save();

        $budget->sendCreatedBudget();

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
        $budget = $this->budget->find($id);

        return view('admin.budgets.show', compact('budget'));
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
                    "amount" => $line['amount'],
                    "index" => $line['index']
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
                    "amount" => $line['amount'],
                    "index" => $line['index']
                ];
            }, $productsTemp);
        }

        $budget->update($data);

        $budget->services()->sync([]);
        $budget->services()->sync($services);
        $budget->products()->sync([]);
        $budget->products()->sync($products);

        $budget->amount = $budget->productAmount + $budget->serviceAmount;
        $budget->save();

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
        $budget = $this->budget->find($id);

        $budget->delete();

        flash('success', 'Budget removed successfully!');

        return redirect(route('admin.budgets.index'));
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

    /**
     * Display a listing of the resource by parameters.
     *
     * @return json
     */
    public function find(Request $request)
    {
        $term = trim($request->q);
        $clientId = $request->client_id;

        if (empty($term)) {
            $budgets = Budget::whereNotIn('status', ['inactived', 'disapproved'])->where('client_id', $clientId)->limit(5)->get();
        } else {
            $budgets = Budget::where('id', 'like', '%' . $term . '%')->where('client_id', $clientId)->limit(5)->get();
        }

        $formatted_budgets = [];

        foreach ($budgets as $budget) {
            $formatted_budgets[] = ['id' => $budget->id, 'text' => $budget->name];
        }

        return \Response::json($formatted_budgets);
    }

    /**
     * Display a listing of the resource by parameters.
     *
     * @return json
     */
    public function findService(Request $request)
    {
        $term = trim($request->q);
        $budgetId = $request->budget_id;

        if (empty($term)) {
            $services = BudgetService::where('budget_id', $budgetId)->limit(5)->get();
        } else {
            $ids = Service::where('name', 'like', '%' . $term . '%')->get()->pluck('id');
            $services = Budget::where('budget_id', $budgetId)->whereIn('service_id', $ids)->get();
        }

        $formatted_services = [];

        foreach ($services as $service) {
            $formatted_services[] = [
                'id' => $service->id,
                'text' => $service->service->name,
                'name' => $service->service->name
            ];
        }

        return \Response::json($formatted_services);
    }
}
