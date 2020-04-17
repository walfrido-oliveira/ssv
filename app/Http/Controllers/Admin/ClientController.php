<?php

namespace App\Http\Controllers\Admin;

use App\Models\Uf;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Client\Client;
use App\Models\Client\Activity;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Session;
use App\Models\Client\Contact\ContactType;
use App\Models\Client\Contact\ClientContact;

class ClientController extends Controller
{
    /**
	 * @var Client
	 */
    private $client;

    /**
     * create a new instance of controll
     */
	public function __construct(Client $client)
	{
        $this->client = $client;

        $this->middleware('permission:client-list|client-create|client-edit|client-delete', ['only' => ['index','store']]);
        $this->middleware('permission:client-create', ['only' => ['create','store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activity = $request->activity;

        if (!is_null($activity))
        {
            $clients = $this->client->where('activity_id', $activity)->paginate(10);
        } else {
            $clients = $this->client->paginate(10);
        }

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ufs = Uf::all()->pluck('full_name', 'uf');
        $citys = City::all();
        $activities = Activity::all()->pluck('name', 'id');
        $contactType = ContactType::all()->pluck('name', 'id');

        return view('admin.clients.create', compact('ufs', 'citys', 'activities', 'contactType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $data = $request->all();

        $data['activity_id'] = $this->createActivity($data['activity_id']);

        $client = $this->client->create($data);

        if (!is_null($request->logo))
        {
            $logo = $request->logo->store('img', ['disk' => 'public']);

            $data['logo'] = $logo;
            $client->update($data);
        }

        $contacts = $data['contacts'];

        foreach ($contacts as $key => $contact)
        {
            $clientContact = ClientContact::create(
                [
                    'client_id' => $client->id,
                    'contact_type_id' => $contact['contact_type_id'],
                    'contact'   => $contact['contact'],
                    'department' => $contact['department'],
                    'phone' => $contact['phone'],
                    'mobile_phone' => $contact['mobile_phone'],
                    'email' => $contact['email'],
                ]
            );
        }

        flash('success', 'Customer added successfully!');

        return redirect(route('admin.clients.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);

        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);

        $ufs = Uf::all()->pluck('full_name', 'uf');
        $citys = City::all();
        $activities = Activity::all()->pluck('name', 'id');
        $contactType = ContactType::all()->pluck('name', 'id');

        return view('admin.clients.edit', compact('client', 'ufs', 'citys', 'activities', 'contactType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        $data = $request->all();

        $client = $this->client::find($id);

        $data['activity_id'] = $this->createActivity($data['activity_id']);

        $client->update($data);

        $oldLogo = $client->logo;

        if (!is_null($request->logo))
        {
            Storage::delete('public/' . $oldLogo);
            $logo = $request->logo->store('img', ['disk' => 'public']);

            $data['logo'] = $logo;
            $client->update($data);
        }

        $contacts = $data['contacts'];

        foreach ($contacts as $key => $contact) {
            if(isset($contact['id']))
            {
                $clientContact = ClientContact::find($contact['id']);
                if(!is_null($clientContact))
                {
                    $clientContact->update($contact);
                }
            } else {
                $contact['client_id'] = $client->id;
                ClientContact::create($contact);
            }
        }

        flash('success', 'Customer updated successfully!');

        return redirect(route('admin.clients.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = $this->client->find($id);

        $budgets = $client->budgets;

        foreach ($budgets as $budget)
        {
            $budget->delete();
        }

        $client->delete();

        flash('success', 'Customer removed successfully!');

        return redirect(route('admin.clients.index'));
    }

    /**
     * Create a inexistent activity
     * @param $activity_id
     */
    private function createActivity($activity_id)
    {
        $activity = Activity::find($activity_id);

        if (is_null($activity))
        {
            $activity = Activity::create([
                'name' => $activity_id
            ]);
        }

        return $activity->id;
    }
}
