<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Client\Client;
use App\Models\Client\Activity;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    /**
	 * @var Activity
	 */
    private $activity;

    /**
     * create a new instance of controll
     */
	public function __construct(Activity $activity)
	{
        $this->activity = $activity;

        $this->middleware('permission:activity-list|activity-create|activity-edit|activity-delete', ['only' => ['index','store']]);
        $this->middleware('permission:activity-create', ['only' => ['create','store']]);
        $this->middleware('permission:activity-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:activity-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = $this->activity->paginate(10);
        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.activities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->activity));

        $this->activity->create($request->all());

        flash('success', 'Activity added successfully!');

        return redirect()->route('admin.activities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = $this->activity->find($id);

        $clients = Client::where('activity_id', $id)->count();

        return view('admin.activities.show', compact('activity', 'clients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activity = $this->activity->find($id);

        return view('admin.activities.edit', compact('activity'));
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
        $activity = $this->activity->find($id);

        $request->validate($this->roles($activity));

        $activity->update($request->all());

        flash('success', 'Activity updated successfully!');

        return redirect()->route('admin.activities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity = $this->activity->find($id);

        $clients = Client::where('activity_id', $id);

        if ($clients->count() > 0)
        {
            flash('error', 'Activity don\'t removed! There is a customer with this activity. Before the to remove, remove the especifics custome, or change this activity.');
            return redirect(route('admin.activities.index'));
        }

        $activity->delete();

        flash('success', 'Activity removed successfully!');

        return redirect(route('admin.activities.index'));
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
            'name' => 'required|max:255|unique:activities,name,' . $activity->id
        ];
    }
}
