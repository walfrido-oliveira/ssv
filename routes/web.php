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

    Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware(['check_user_type:Admin'])->group( function(){

        Route::prefix('profile')->name('profile.')->group(function(){
            Route::get('/', 'ProfileController@show')->name('show');
            Route::put('/{user}', 'ProfileController@update')->name('update');

            Route::prefix('credentials')->name('credentials.')->group(function(){
                Route::get('/', 'CredentialController@show')->name('show');
                Route::put('/{user}', 'CredentialController@update')->name('update');
            });
        });

        Route::get('/clients/find', 'ClientController@find');
        Route::resource('clients', 'ClientController');

        Route::resource('activities', 'ActivityController');

        Route::get('/services/find', 'ServiceController@find');
        Route::resource('services', 'ServiceController');

        Route::get('/products/find', 'ProductController@find');
        Route::resource('products', 'ProductController');

        Route::resource('categories', 'ProductCategoryController');

        Route::resource('budget-types', 'BudgetTypeController');

        Route::resource('payment-methods', 'PaymentMethodController');

        Route::resource('transport-methods', 'TransportMethodController');

        Route::resource('budgets', 'BudgetController');

        Route::prefix('contacts')->name('contacts.')->group(function(){
            Route::get('/find', 'ClientContactController@find');
            Route::delete('/{contact}', 'ClientContactController@destroy')->name('destroy');
        });

    });

    Route::prefix('user')->name('user.')->namespace('User')->middleware(['check_user_type:User'])->group(function(){

        Route::prefix('budgets')->name('budgets.')->group(function(){
            Route::get('/', 'BudgetController@index')->name('index');
            Route::get('/{budget}', 'BudgetController@show')->name('show');
        });

    });

});



