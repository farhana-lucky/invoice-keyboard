<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('customer/{invoice:number}', 'HomeController@customer')->name('customer');
Route::post('customer-store/{invoice:number}', 'HomeController@customer_store')->name('customer_store');

Route::name('profile.')->prefix('profile')->group(function () {
    Route::get('', 'HomeController@info')->name('info');
    Route::post('password-change', 'HomeController@password_change')->name('password_change');
});

Route::name('invoice.')->group(function () {
    Route::get('/', 'InvoiceController@create')->name('create');
    Route::post('store', 'InvoiceController@store')->name('store');
    Route::get('edit/{invoice:number}', 'InvoiceController@edit')->name('edit');
    Route::post('update/{invoice:number}', 'InvoiceController@update')->name('update');
    Route::get('mail/{invoice:number}', 'InvoiceController@mail')->name('mail');
    Route::get('delete/{invoice:number}', 'InvoiceController@delete')->name('delete');
    Route::get('print/{invoice:number}', 'InvoiceController@print')->name('print');
    Route::get('list', 'InvoiceController@list')->name('list');
    Route::post('data-table', 'InvoiceController@dataTable')->name('dataTable');
    Route::get('{invoice}', 'InvoiceController@wild')->name('wild');
});
