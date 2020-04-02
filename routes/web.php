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

Route::group(['middleware' => ['auth']], function() {
    Route::get('services', function() {
        /*$client = App\Models\Client\Client::find(2);
        $client->im = '123';
        $client->save();
        return $client->activity;
        */

        $service = App\Models\Service\Service::find(1);
        return $service->getAmount();
    });
});


