<?php

namespace App\Http\Controllers\JSON;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use \App\Role\UserRole;

class JSONController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:client-create', ['only' => ['getAdressInformations','getCustomerInformations']]);
        $this->middleware('permission:client-edit', ['only' => ['getAdressInformations','getCustomerInformations']]);
    }

    /**
     * Get informations of adress by cep cod
     *
     * @return json
     */
    public function getAdressInformations(Request $request)
    {
        $url = config('app.webmaniabr.URL') .
        $request->cep.
               "/?app_key=".
               config('app.webmaniabr.APP_KEY').
               "&app_secret=".
               config('app.webmaniabr.APP_SECRET');

        $json = file_get_contents($url);

        $sen['sucess'] = true;
        $sen['result'] = json_decode($json);

        return Response::json( $sen );
    }

    /**
     * Get informations of CNPJ
     *
     * @return json
     */
    public function getCustomerInformations(Request $request)
    {
        $url = config('app.receitaws.URL') . $request->cnpj;

        $json = file_get_contents($url);

        $sen['sucess'] = true;
        $sen['result'] = json_decode($json);

        return Response::json( $sen );
    }


}
