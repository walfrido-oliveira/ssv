<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Budget\Budget;
use App\Models\Service\Service;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
	 * @var Service
	 */
    private $service;

    /**
     * create a new instance of controll
     */
	public function __construct(Service $service)
	{
        $this->service = $service;

        $this->middleware('permission:service-list|service-create|service-edit|service-delete', ['only' => ['index','store']]);
        $this->middleware('permission:service-create', ['only' => ['create','store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->service->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->service));

        $this->service->create($request->all());

        flash('success', 'Service added successfully!');

        return redirect()->route('admin.services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $service = $this->service->where('slug', $slug)->first();

        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $service = $this->service->where('slug', $slug)->first();

        return view('admin.services.edit', compact('service'));
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
        $service = $this->service->find($id);

        $request->validate($this->roles($service));

        $service->update($request->all());

        flash('success', 'Service updated successfully!');

        return redirect()->route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = $this->service->find($id);

        $budgets = Budget::with('services')->whereHas('services', function ($query) use($service) {
            $query->where('services.id', $service->id);
        });

        if ($budgets->count() > 0)
        {
            flash('error', 'Service don\'t removed! There is a budget with this service. Before the to remove, remove the especifics budget, or remove this service.');
            return redirect(route('admin.services.index'));
        }

        $service->delete();

        flash('success', 'Service removed successfully!');

        return redirect(route('admin.services.index'));
    }

    /**
     * Get rules of validation
     * @param Service $service
     * @return array
     */
    public function roles($service)
    {
        return
        [
            'name' => 'required|max:255|unique:services,name,' . $service->id,
            'price' => 'required|numeric',
            'description' => 'nullable|max:255'
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

        if (empty($term)) {
            $services = Service::where('id', '>', 0)->limit(5)->get();
        } else {
            $services = Service::where('name', 'like', '%' . $term . '%')->limit(5)->get();
        }

        $formatted_services = [];

        foreach ($services as $service) {
            $formatted_services[] =
            [
                'id' => $service->id,
                'text' => $service->name,
                'price' => $service->price
            ];
        }

        return \Response::json($formatted_services);
    }
}
