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

Auth::routes(['verify' => false]);


Route::group(['middleware' => ['auth']], function() {

    Route::get('/', function () {
        return redirect('/home');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware(['check_user_type:Admin'])->group( function(){

        Route::prefix('profile')->name('profile.')->group(function(){
            Route::get('/', 'ProfileController@show')->name('show');
            Route::put('/', 'ProfileController@update')->name('update');

            Route::prefix('credentials')->name('credentials.')->group(function(){
                Route::get('/', 'CredentialController@show')->name('show');
                Route::put('/', 'CredentialController@update')->name('update');
            });
        });

        Route::get('/clients/find', 'ClientController@find');
        Route::get('/clients/cep','\App\Http\Controllers\JSON\JSONController@getAdressInformations')->middleware('auth');
        Route::get('/clients/cnpj','\App\Http\Controllers\JSON\JSONController@getCustomerInformations')->middleware('auth');
        Route::resource('clients', 'ClientController');

        Route::resource('activities', 'ActivityController');

        Route::get('/services/find', 'ServiceController@find');
        Route::resource('services', 'ServiceController');

        Route::get('/service-types/find', 'ServiceTypeController@find');
        Route::resource('service-types', 'ServiceTypeController');

        Route::get('/products/find', 'ProductController@find');
        Route::resource('products', 'ProductController');

        Route::resource('categories', 'ProductCategoryController');

        Route::resource('budget-types', 'BudgetTypeController');

        Route::resource('payment-methods', 'PaymentMethodController');

        Route::resource('transport-methods', 'TransportMethodController');

        Route::get('/budgets/find', 'BudgetController@find');
        Route::get('/budgets/find-service', 'BudgetController@findService');
        Route::resource('budgets', 'BudgetController');

        Route::resource('orders', 'OrderController');

        Route::prefix('contacts')->name('contacts.')->group(function(){
            Route::get('/find', 'ClientContactController@find');
            Route::delete('/{contact}', 'ClientContactController@destroy')->name('destroy');
        });

        Route::resource('users', 'UserController');

    });

    Route::prefix('user')->name('user.')->namespace('User')->middleware(['check_user_type:User'])->group(function(){

        Route::prefix('budgets')->name('budgets.')->group(function(){
            Route::get('/', 'BudgetController@index')->name('index');
            Route::get('/{budget}', 'BudgetController@show')->name('show');
            Route::put('/approve/{budget}', 'BudgetController@approve')->name('approve');
            Route::put('/disapprove/{budget}', 'BudgetController@disapprove')->name('disapprove');
        });

        Route::prefix('billings')->name('billings.')->group(function(){
            Route::get('/', 'BillingController@index')->name('index');
            Route::get('/{billing}', 'BillingController@show')->name('show');
        });

        Route::prefix('checkout')->name('checkout.')->group(function(){
            Route::get('/', 'CheckoutController@index')->name('index');
            Route::post('/proccess', 'CheckoutController@proccess')->name('proccess');
            Route::get('/thanks', 'CheckoutController@thanks')->name('thanks');
        });

        Route::prefix('profile')->name('profile.')->group(function(){
            Route::get('/', 'ProfileController@show')->name('show');
            Route::put('/', 'ProfileController@update')->name('update');

            Route::prefix('credentials')->name('credentials.')->group(function(){
                Route::get('/', 'CredentialController@show')->name('show');
                Route::put('/', 'CredentialController@update')->name('update');
            });
        });

    });

});



