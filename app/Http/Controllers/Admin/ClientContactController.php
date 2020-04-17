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
}
