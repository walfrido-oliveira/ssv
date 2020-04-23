<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Budget\BudgetType;
use App\Http\Controllers\Controller;

class BudgetTypeController extends Controller
{
    /**
	 * @var BudgetType
	 */
    private $budgetType;

    /**
     * create a new instance of controll
     */
	public function __construct(BudgetType $budgetType)
	{
        $this->budgetType = $budgetType;

        $this->middleware('permission:budget-type-list|budget-type-create|budget-type-edit|budget-type-delete', ['only' => ['index','store']]);
        $this->middleware('permission:budget-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:budget-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:budget-type-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budgetTypes = $this->budgetType->paginate(10);
        return view('admin.budget-types.index', compact('budgetTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.budget-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->budgetType));

        $this->budgetType->create($request->all());

        flash('success', 'Type added successfully!');

        return redirect()->route('admin.budget-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $budgetType = $this->budgetType->where('slug', $slug)->first();

        return view('admin.budget-types.show', compact('budgetType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $budgetType = $this->budgetType->where('slug', $slug)->first();

        return view('admin.budget-types.edit', compact('budgetType'));
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
        $budgetType = $this->budgetType->find($id);

        $request->validate($this->roles($budgetType));

        $budgetType->update($request->all());

        flash('success', 'Type updated successfully!');

        return redirect()->route('admin.budget-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $budgetType = $this->budgetType->find($id);

        $budget = Budget::where('budget_type_id', $id);

        if ($budget->count() > 0)
        {
            flash('error', 'Type don\'t removed! There is a budget with this activity. Before the to remove, remove the especifics budget, or change this budget.');
            return redirect(route('admin.budget-types.index'));
        }

        $budgetType->delete();

        flash('success', 'Type removed successfully!');

        return redirect(route('admin.budget-types.index'));
    }

    /**
     * Get rules of validation
     *
     * @param Activity $activity
     * @return array
     */
    public function roles($activity)
    {
        return
        [
            'name' => 'required|max:255|unique:budget_types,name,' . $activity->id
        ];
    }
}
