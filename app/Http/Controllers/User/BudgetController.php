<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Billing\Billing;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

        $this->middleware('permission:budget-list', ['only' => ['index']]);
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
            $budgets = $this->budget
            ->whereIn('client_id', $clients)
            ->paginate(10);
        } else if($request->has('status')) {
            $budgets = $this->budget->where('status', '=', $request->status)
            ->whereIn('client_id', $clients)
            ->paginate(10);
        } else {
            $budgets = $this->budget
            ->whereIn('client_id', $clients)
            ->where(function($query) use ($term) {
                $query->whereHas('client', function($query) use ($term) {
                    $query->where('clients.razao_social', 'like', '%' . $term . '%');
                })->orwhere('id', '=', $term)
                ->orwhere('amount', '=', is_numeric($term) ? $term : true);
            })
            ->paginate(10);
        }

        return view('user.budgets.index', compact('budgets'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$this->budget->checkClient($id)) abort(404);

        $budget = $this->budget->find($id);

        return view('user.budgets.show', compact('budget'));
    }

    /**
     * Approve a specific budget
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if (!$this->budget->checkClient($id))
        {
            flash('error', 'This budget dont exist!');
            return redirect()->back();
        }

        $budget = $this->budget->find($id);

        $status = $budget->status;

        if ($status == 'created')
        {
            $budget->status = 'approved';
            $budget->approved_at = now();
            $budget->save();

            $budget->sendApprovedBudget();

            $billing = Billing::create([
                'budget_id' => $budget->id,
                'client_id' => $budget->client->id,
                'payment_method_id' => $budget->paymentMethod->id,
                'due_date' => $budget->approved_at->addDays(30),
                'amount' => $budget->amount,
            ]);

            $billing->sendCreatedBilling();

            flash('success', 'Budget approved successfully!');
        }

        if ($status == 'approved')
        {
            flash('warning', 'Budget already approved!');
        }

        if ($status == 'disapproved')
        {
            flash('error', 'Budget was previously disapproved!');
        }

        return redirect()->back();
    }

    /**
     * Disapprove a specific budget
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disapprove($id)
    {
        if (!$this->budget->checkClient($id))
        {
            flash('error', 'This budget dont exist!');
            return redirect()->back();
        }

        $budget = $this->budget->find($id);

        $status = $budget->status;

        if ($status == 'created')
        {
            $budget->status = 'disapproved';
            $budget->disapproved_at = now();
            $budget->save();

            $budget->sendDisapprovedBudget();

            flash('success', 'Budget disapproved successfully!');
        }

        if ($status == 'approved')
        {
            flash('warning', 'Budget already approved!');
        }

        if ($status == 'disapproved')
        {
            flash('error', 'Budget was previously disapproved!');
        }

        return redirect()->back();
    }


}
