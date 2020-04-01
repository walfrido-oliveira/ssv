<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('clients', function() {
    /*$client = App\Models\Client\Client::find(2);
    $client->im = '123';
    $client->save();
    return $client->activity;
    */

    $contact = App\Models\Client\Contact\ClientContact::find(1);
    $contact->contact = "ok";
    $contact->save();
    return $contact->contactType;
});
