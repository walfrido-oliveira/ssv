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
        $budgets = $this->budget->paginate(10);
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
        $budget = $this->budget->find($id);

        return view('user.budgets.show', compact('budget'));
    }


}
