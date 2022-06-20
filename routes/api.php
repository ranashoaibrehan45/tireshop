<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user/verify/{token}', 'AuthController@verifyUser');
Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');

Route::get('get/companies', 'CommonController@getCompanies');

Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('auth/user', 'AuthController@user');
  Route::post('logout', 'AuthController@logout');
  Route::post('update/account', 'AuthController@updateAccount');
  
  Route::get('get/companies','CompanyController@getAll');
  Route::get('get/venders','VenderController@getAll');
  Route::get('get/sizes','TireSizeController@getAll');
  Route::get('get/tires', 'TireController@getAll');
  Route::get('get/tire_stock/{company_id}/{size_id}', 'TireStockController@getTiresByCompanyAndSize');
  Route::get('get/expense','ExpenseController@getAll');
  Route::get('get/services', 'ServiceController@getAll');

  //Route::resource('user', 'UserController');
  Route::resource('company', 'CompanyController');
  Route::resource('tire_size', 'TireSizeController');
  Route::resource('vender', 'VenderController');
  Route::resource('service', 'ServiceController');
  Route::resource('tire', 'TireController');
  Route::resource('tire_stock', 'TireStockController');
  Route::resource('invoice', 'InvoiceController');
  Route::resource('expense', 'ExpenseController');
  Route::resource('expense_payment', 'ExpensePaymentController');
});

Route::group(['middleware' => 'jwt.refresh'], function(){
  Route::get('auth/refresh', 'AuthController@refresh');
});