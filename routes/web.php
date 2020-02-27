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
    return view('auth.login');
});

Auth::routes();

Route::group (['middleware' => 'auth'], function ()
{
    Route::get('/print_ris' , 'PPMPController@print_ris');
    Route::get('/print_carried_stock/{id}' , 'StockController@print_carried_stock');
    Route::post('/print_issued_stocks' , 'StockController@print_issued_stocks');
    Route::get ('/fetch_supplier', 'StockController@fetch_supplier');
    Route::get ('/fetch_uPrice/{id}', 'StockController@fetch_uPrice');
    Route::get ('/fetch_location', 'StockController@fetch_location');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get ('/create_location', 'StockController@create_location');
    Route::post ('/store_location', 'StockController@store_location');

    Route::get ('/create_supplier', 'StockController@create_supplier');
    Route::post ('/store_supplier', 'StockController@store_supplier');

    Route::get('/create_stock' , 'StockController@create_stock');
    Route::post('/store_stock' , 'StockController@store_stock');
    Route::get('/receive_stock' , 'StockController@receive_stock');
    Route::post('/receiving_stock' , 'StockController@receiving_stock');
    Route::get('/search_stock', 'StockController@search_stock');
    Route::post('/stocks/{id}', 'StockController@edit_receive_stock')->name ('receive_stock');
    Route::post('/update_receive_stock', 'StockController@update_receive_stock');
    Route::post('/search_results', 'StockController@search_stock');
    Route::get('/search_carried_stock', 'StockController@search_carried_stock');
    Route::post('/receive_stock_final', 'StockController@receive_stock_final');
    Route::post('/edit_to_receive/{id}', 'StockController@edit_to_receive')->name('edit_to_receive');
    Route::post('/destroy_to_receive/{id}', 'StockController@destroy_to_receive')->name('destroy_to_receive');

    Route::get('/create_stock_cost/{id}', 'StockController@create_stock_cost');
    Route::post('/store_stock_cost', 'StockController@store_stock_cost');
    Route::get('/edit_stock/{id}' , 'StockController@edit_stock');
    Route::post ('/update_stock/{id}', 'StockController@update_stock')->name('update_stock');
    Route::get('/destroy_stock/{id}' , 'StockController@destroy_stock');

    Route::get('/issue_stock' , 'StockController@issue_stock');
    Route::post('/issuing_stock' , 'StockController@issuing_stock');
    Route::get ('/edit_issue_stock/{id}', 'StockController@edit_issue_stock')->name ('issue_stock');
    Route::post('/issued_stock', 'StockController@issued_stock');
    Route::post('/issue_stock_final', 'StockController@issue_stock_final');
    Route::post('/add_issue_stock', 'StockController@add_issue_stock');
    Route::post('/edit_to_issue/{id}', 'StockController@edit_to_issue')->name('edit_to_issue');
    Route::post('/destroy_to_issue/{id}', 'StockController@destroy_to_issue')->name('destroy_to_issue');

    Route::get('/edit_transaction/{id}' , 'StockController@edit_transaction');
    Route::post ('/update_transaction/{id}', 'StockController@update_transaction')->name('update_transaction');;
    Route::get('/destroy_transaction/{id}' , 'StockController@destroy_transaction');

    Route::get('/trace_stock' , 'StockController@trace_stock');
    Route::get('/list_stock' , 'StockController@list_stock');
    Route::get('/carried_stock' , 'StockController@carried_stock');
    Route::get('/report_issued_stock' , 'StockController@report_issued_stock');
    Route::get('/search_report_issued_stock' , 'StockController@search_report_issued_stock');
    Route::post('/stocks_review' , 'StockController@stock_details');

    Route::post ('/search_menu_stock', 'StockController@search_menu_stock');

    Route::get ('/edit_supplier/{id}', 'StockController@edit_supplier');
    Route::get ('/destroy_supplier/{id}', 'StockController@destroy_supplier');
    Route::post ('/update_supplier', 'StockController@update_supplier');
    Route::resource ('supplier', 'SupplierController');

    Route::get ('/list_location', 'StockController@list_location');
    Route::get ('/edit_location/{id}', 'StockController@edit_location');
    Route::get ('/destroy_location/{id}', 'StockController@destroy_location');
    Route::post ('/update_location', 'StockController@update_location');

    Route::get ('/create_location_account', 'StockController@create_location_account');

    Route::get ('/create_ppmp', 'PPMPController@create');
    Route::post ('/generate/ppmp', 'PPMPController@generate');
    Route::get ('/current_ppmp', 'PPMPController@current');
    Route::get ('/past_ppmp', 'PPMPController@past');
    Route::post ('/get_past_ppmp', 'PPMPController@get_past');
    Route::post ('/update_ppmp/{id}', 'PPMPController@update')->name ('update_ppmp');
    Route::post ('/destroy_ppmp/{id}', 'PPMPController@destroy')->name ('destroy_ppmp');
});