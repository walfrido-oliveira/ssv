<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order\OrderService;
use App\Models\Service\ServiceType;
use App\Http\Controllers\Controller;
use App\Models\Budget\TransportMethod;

class ServiceTypeController extends Controller
{
    /**
	 * @var ServiceType
	 */
    private $serviceType;

    /**
     * create a new instance of controll
     */
	public function __construct(ServiceType $serviceType)
	{
        $this->serviceType = $serviceType;

        $this->middleware('permission:service-type-list|service-type-create|service-type-edit|service-type-delete', ['only' => ['index','store']]);
        $this->middleware('permission:service-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:service-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:service-type-delete', ['only' => ['destroy']]);
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

        if (!empty($term)) {
            $serviceTypes = $this->serviceType
            ->where('id', '=', $term )
            ->orwhere('name', 'like', '%' . $term . '%')
            ->paginate(10);
        } else {
            $serviceTypes = $this->serviceType->paginate(10);
        }

        return view('admin.service-types.index', compact('serviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->serviceType));

        $this->serviceType->create($request->all());

        flash('success', 'Service Type added successfully!');

        return redirect()->route('admin.service-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $serviceType = $this->serviceType->where('slug', $slug)->first();

        return view('admin.service-types.show', compact('serviceType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $serviceType = $this->serviceType->where('slug', $slug)->first();

        return view('admin.service-types.edit', compact('serviceType'));
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
        $serviceType = $this->serviceType->find($id);

        $request->validate($this->roles($serviceType));

        $serviceType->update($request->all());

        flash('success', 'Service Type updated successfully!');

        return redirect()->route('admin.service-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serviceType = $this->serviceType->find($id);

        $clients = OrderService::where('service_type_id', $id);

        if ($clients->count() > 0)
        {
            flash('error', 'Service Type don\'t removed! There is a order with this. Before the to remove, remove the especifics order, or change this method.');
            return redirect(route('admin.service-types.index'));
        }

        $serviceType->delete();

        flash('success', 'Service Type removed successfully!');

        return redirect(route('admin.service-types.index'));
    }

    /**
     * Get rules of validation
     *
     * @param ServiceType serviceType
     * @return array
     */
    public function roles($serviceType)
    {
        return
        [
            'name' => 'required|max:255|unique:service_types,name,' . $serviceType->id
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
            $services = ServiceType::limit(5)->get();
        } else {
            $services = ServiceType::where('name', 'like', '%' . $term . '%')->limit(5)->get();
        }

        $formatted_services = [];

        foreach ($services as $service) {
            $formatted_services[] = [
                'id' => $service->id,
                'text' => $service->name,
                'name' => $service->name
            ];
        }

        return \Response::json($formatted_services);
    }
}
