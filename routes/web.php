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

Route::get('/form/{unique_id}', 'Open\FormController@main');
Route::post('/form/submit/{location_id}', 'Open\FormController@submit');
Route::get('/form/receipt/summary', 'Open\FormController@receipt');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('/temperature', 'Admin\TemperatureController@index');
    Route::get('/temperature/filter', 'Admin\TemperatureController@filter');
    Route::get('/temperature/details', 'Admin\TemperatureController@details');
    Route::get('/temperature/update', 'Admin\TemperatureController@update');
    
    Route::get('/location', 'Admin\LocationController@main');
    Route::get('/location/single/{location_id}', 'Admin\LocationController@single_details');
    Route::get('/location/create', 'Admin\LocationController@create');
    Route::post('/location/save', 'Admin\LocationController@save');
    Route::get('/location/edit/{location_id}', 'Admin\LocationController@edit');
    Route::post('/location/update', 'Admin\LocationController@update');
    Route::get('/location/delete/{location_id}', 'Admin\LocationController@delete');
    Route::get('/location/generate/{hash}', 'Admin\LocationController@generateQR');
    Route::get('/location/getdata/{location_id}', 'Admin\LocationController@getdata');

    Route::get('/data', 'Admin\DataController@main');

});