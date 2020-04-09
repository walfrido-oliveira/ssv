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

        Route::prefix('profile')->name('profile.')->group(function(){
            Route::get('/', 'ProfileController@show')->name('show');
            Route::put('/{user}', 'ProfileController@update')->name('update');

            Route::prefix('credentials')->name('credentials.')->group(function(){
                Route::get('/', 'CredentialController@show')->name('show');
                Route::put('/{user}', 'CredentialController@update')->name('update');
            });
        });

        //Route::prefix('clients')->name('clients.')->group(function(){
            //Route::get('/', 'ClientController@index')->name('index');

            Route::resource('clients', 'ClientController');
        //});

    });

});



