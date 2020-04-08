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
    return redirect('/home');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function(){

        Route::get('/profile', 'ProfileController@show')->name('profile.show');
        Route::put('/profile/{id}', 'ProfileController@update')->name('profile.update');

    });

    Route::get('products', function() {
        /*$client = App\Models\Client\Client::find(2);
        $client->im = '123';
        $client->save();
        return $client->activity;
        */

        $service = App\Models\Service\Service::find(1);
        $service->serviceTypes()->sync([2, 1]);

        //return  $service->serviceTypes;

        //$products = App\Models\Product\Product::find(1);
        //return $products;

        $budget = App\Models\Budget\Budget::find(1);

        return $budget->getProductAmount();
    });
});



