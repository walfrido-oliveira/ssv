<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client\Contact\ClientContact;

class ClientContactController extends Controller
{
    /**
	 * @var ClientContact
	 */
    private $clientContact;

    /**
     * create a new instance of controll
     */
	public function __construct(ClientContact $clientContact)
	{
        $this->clientContact = $clientContact;

        $this->middleware('permission:client-contact-list|client-contact-create|client-contact-edit|client-contact-delete',
                            ['only' => ['index','store','find']]);
        $this->middleware('permission:client-contact-create', ['only' => ['create','store']]);
        $this->middleware('permission:client-contact-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:client-contact-delete', ['only' => ['destroy']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clientContact = $this->clientContact->find($id);

        if (!is_null($clientContact))
        {
            $clientContact->delete();

            return response()->json([
                'message' => __('Contact deleted successfully!')
            ]);
        } else {
            return response()->json([
                'message' => __('Contact dont exist'),
                500
            ]);
        }

    }

    /**
     * Display a listing of the resource by parameters.
     *
     * @return json
     */
    public function find(Request $request)
    {
        $term = trim($request->q);
        $clientId = trim($request->client_id);

        if (!is_null($clientId))
        {
            $contacts = ClientContact::where('client_id', $clientId)
                ->limit(5)->get();
        } else if(!is_null($term)) {
            $contacts = ClientContact::where('contact', 'like', '%' . $term . '%')
                ->where('client_id', $clientId)
                ->limit(5)->get();
        }

        $formatted_contacts = [];

        foreach ($contacts as $contact) {
            $formatted_contacts[] = ['id' => $contact->id,
                                    'contact' => $contact->contact,
                                    'department' => $contact->department,
                                    'phone' => $contact->phone,
                                    'mobile_phone' => $contact->mobile_phone,
                                    'email' => $contact->email,
                                   ];
        }

        return \Response::json($formatted_contacts);
    }
}
