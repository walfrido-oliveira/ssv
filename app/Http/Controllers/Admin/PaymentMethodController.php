<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Http\Controllers\Controller;
use App\Models\Budget\PaymentMethod;

class PaymentMethodController extends Controller
{
    /**
	 * @var PaymentMethod
	 */
    private $paymentMethod;

    /**
     * create a new instance of controll
     */
	public function __construct(PaymentMethod $paymentMethod)
	{
        $this->paymentMethod = $paymentMethod;

        $this->middleware('permission:payment-method-list|payment-method-create|payment-method-edit|payment-method-delete', ['only' => ['index','store']]);
        $this->middleware('permission:payment-method-create', ['only' => ['create','store']]);
        $this->middleware('permission:payment-method-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:payment-method-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = $this->paymentMethod->paginate(10);
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->paymentMethod));

        $this->paymentMethod->create($request->all());

        flash('success', 'Payment Method added successfully!');

        return redirect()->route('admin.payment-methods.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentMethod = $this->paymentMethod->find($id);

        return view('admin.payment-methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentMethod = $this->paymentMethod->find($id);

        return view('admin.payment-methods.edit', compact('paymentMethod'));
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
        $paymentMethod = $this->paymentMethod->find($id);

        $request->validate($this->roles($paymentMethod));

        $paymentMethod->update($request->all());

        flash('success', 'Payment Method updated successfully!');

        return redirect()->route('admin.payment-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentMethod = $this->paymentMethod->find($id);

        $clients = Budget::where('payment_method_id', $id);

        if ($clients->count() > 0)
        {
            flash('error', 'Payment Method don\'t removed! There is a budget with this. Before the to remove, remove the especifics budget, or change this method.');
            return redirect(route('admin.payment-methods.index'));
        }

        $paymentMethod->delete();

        flash('success', 'Payment Method removed successfully!');

        return redirect(route('admin.payment-methods.index'));
    }

    /**
     * Get rules of validation
     *
     * @param Payment Method paymentMethod
     * @return array
     */
    public function roles($paymentMethod)
    {
        return
        [
            'name' => 'required|max:255|unique:payment_methods,name,' . $paymentMethod->id
        ];
    }
}
