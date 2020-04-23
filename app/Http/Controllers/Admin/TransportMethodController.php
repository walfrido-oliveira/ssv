<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Http\Controllers\Controller;
use App\Models\Budget\TransportMethod;

class TransportMethodController extends Controller
{
    /**
	 * @var TransportMethod
	 */
    private $transportMethod;

    /**
     * create a new instance of controll
     */
	public function __construct(TransportMethod $transportMethod)
	{
        $this->transportMethod = $transportMethod;

        $this->middleware('permission:transport-method-list|transport-method-create|transport-method-edit|transport-method-delete', ['only' => ['index','store']]);
        $this->middleware('permission:transport-method-create', ['only' => ['create','store']]);
        $this->middleware('permission:transport-method-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:transport-method-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transportMethods = $this->transportMethod->paginate(10);
        return view('admin.transport-methods.index', compact('transportMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.transport-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->transportMethod));

        $this->transportMethod->create($request->all());

        flash('success', 'Transport Method added successfully!');

        return redirect()->route('admin.transport-methods.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $transportMethod = $this->transportMethod->where('slug', $slug)->first();

        return view('admin.transport-methods.show', compact('transportMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $transportMethod = $this->transportMethod->where('slug', $slug)->first();

        return view('admin.transport-methods.edit', compact('transportMethod'));
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
        $transportMethod = $this->transportMethod->find($id);

        $request->validate($this->roles($transportMethod));

        $transportMethod->update($request->all());

        flash('success', 'Transport Method updated successfully!');

        return redirect()->route('admin.transport-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transportMethod = $this->transportMethod->find($id);

        $clients = Budget::where('transport_method_id', $id);

        if ($clients->count() > 0)
        {
            flash('error', 'Transport Method don\'t removed! There is a budget with this. Before the to remove, remove the especifics budget, or change this method.');
            return redirect(route('admin.transport-methods.index'));
        }

        $transportMethod->delete();

        flash('success', 'Transport Method removed successfully!');

        return redirect(route('admin.transport-methods.index'));
    }

    /**
     * Get rules of validation
     *
     * @param Transport Method transportMethod
     * @return array
     */
    public function roles($transportMethod)
    {
        return
        [
            'name' => 'required|max:255|unique:transport_methods,name,' . $transportMethod->id
        ];
    }
}
