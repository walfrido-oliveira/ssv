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
use Illuminate\Support\Facades\Storage;
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
        $term = trim($request->q);

        if (!is_null($activity))
        {
            $clients = $this->client
            ->where('activity_id', $activity)
            ->paginate(10);
        } else if($request->has('status')) {
            $clients = $this->client
            ->where('status', '=', $request->status)
            ->paginate(10);
        } else if(!empty($term)) {
            $clients = $this->client
            ->where('nome_fantasia', 'like', '%' . $term .'%')
            ->orwhere('id', '=', $term)
            ->paginate(10);
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
        $contactTypes = ContactType::all()->pluck('name', 'id');

        return view('admin.clients.create', compact('ufs', 'citys', 'activities', 'contactTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $data = $this->sanitize($request->all());

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
            $contact['contact_type_id'] = $this->createContact($contact['contact_type_id']);

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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $client = Client::where('slug', $slug)->first();

        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $client = Client::where('slug', $slug)->first();

        $ufs = Uf::all()->pluck('full_name', 'uf');
        $citys = City::all();
        $activities = Activity::all()->pluck('name', 'id');
        $contactTypes = ContactType::all()->pluck('name', 'id');

        return view('admin.clients.edit', compact('client', 'ufs', 'citys', 'activities', 'contactTypes'));
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
        $data = $this->sanitize($request->all());

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

            $contact['contact_type_id'] = $this->createContact($contact['contact_type_id']);

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
     * Create a new activity
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

    /**
     * Create a new contact
     * @param $activity_id
     */
    private function createContact($contact_type_id)
    {
        $contact = ContactType::find($contact_type_id);

        if (is_null($contact))
        {
            $contact = ContactType::create([
                'name' => $contact_type_id
            ]);
        }

        return $contact->id;
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
            $clients = Client::where('status', 'active')->limit(5)->get();
        } else {
            $clients = Client::where('nome_fantasia', 'like', '%' . $term . '%')->limit(5)->get();
        }

        $formatted_clients = [];

        foreach ($clients as $client) {
            $formatted_clients[] = ['id' => $client->id, 'text' => $client->nome_fantasia];
        }

        return \Response::json($formatted_clients);
    }

    /**
     * Sanitize all fields of cliente resource
     *
     * @param Array $data
     *
     * @return Array
     */
    private function sanitize($data)
    {
        $data['client_id'] = sanitize_var($data['client_id'], FILTER_SANITIZE_NUMBER_INT);
        $data['adress_cep'] = sanitize_var($data['adress_cep'], FILTER_SANITIZE_NUMBER_INT);

        foreach ($data['contacts'] as $key => $value) {
            $value['phone'] = sanitize_var($value['phone'], FILTER_SANITIZE_NUMBER_INT);
            $value['mobile_phone'] = sanitize_var($value['mobile_phone'], FILTER_SANITIZE_NUMBER_INT);
        }

        return $data;
    }
}
