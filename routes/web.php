<?php

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

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/test', 'HomeController@test')->name('test');
Route::get('/test1', 'HomeController@test')->name('test1');
Route::get('/test2', 'HomeController@test2')->name('test2');

//suppliers url
Route::get('/suppliers', 'HomeController@suppliers')->name('suppliers');
Route::get('/supplier/details/{id}', 'HomeController@supplierdetails')->name('supplierdetails');
Route::get('/supplier/edit/{id}', 'HomeController@supplieredit')->name('supplieredit');
Route::post('/storesuppliers', 'HomeController@storesuppliers')->name('storesuppliers');
Route::post('/updatesupplier', 'HomeController@updatesupplier')->name('updatesupplier');


//bills url
Route::get('/bills', 'HomeController@bills')->name('bills');
Route::get('/biils/edit/{id}', 'HomeController@editbills')->name('editbills');
Route::post('/storebills', 'HomeController@storebills')->name('storebills');
Route::post('/updatebills', 'HomeController@updatebills')->name('updatebills');



Route::get('/payments', 'HomeController@payments')->name('payments');
Route::get('/payments/edit/{id}', 'HomeController@editpayment')->name('editpayment');
Route::post('/storepayments', 'HomeController@storepayments')->name('storepayments');
Route::post('/updatepayment', 'HomeController@updatepayment')->name('updatepayment');



Route::get('/calendar/{m}/{y}', 'HomeController@calendar')->name('calendar');

