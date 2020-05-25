<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Budget\Budget;
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

        $this->middleware('permission:budget-list|budget-create|budget-edit|budget-delete', ['only' => ['index','store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = $this->getClientsId();
        $budgets = $this->budget->whereIn('client_id', $clients)->paginate(10);

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
        If (!$this->checkClient($id)) abort(404);

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
        if (!$this->checkClient($id))
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
        if (!$this->checkClient($id))
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

    /**
     * Get all ids client for user
     *
     * @return array
     */
    private function getClientsId()
    {
        return auth()->user()->clients()->pluck('client_user.client_id');
    }

    /**
     * Check if client user has acess to budget
     *
     * @param  int  $id
     *
     * @return boolean
     */
    private function checkClient($id)
    {
        $clients = $this->getClientsId();

        $budgets = $this->budget->whereIn('client_id', $clients)->where('id', $id)->first();

        return !is_null($budgets);

    }


}
