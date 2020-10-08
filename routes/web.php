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

Route::get('/form/staff/clockout', 'Open\FormController@staff_clockout');
Route::post('/form/staff/clockoutprocess', 'Open\FormController@staff_clockoutprocess');

Route::get('/form/{unique_id}', 'Open\FormController@main');
Route::post('/form/submit/{location_id}', 'Open\FormController@submit');
Route::get('/form/receipt/summary', 'Open\FormController@receipt');
Route::get('/form/staff/{unique_id}', 'Open\FormController@staff_form');
Route::post('/form/staff/submit/{unique_id}', 'Open\FormController@staff_submit');
Route::get('/form/receipt/staff/summary', 'Open\FormController@receipt_staff');
Route::get('/form/kontraktor/{unique_id}', 'Open\FormController@kontraktor_form');
Route::post('/form/kontraktor/submit/{unique_id}', 'Open\FormController@kontraktor_submit');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', 'HomeController@dashboard');
    Route::get('/temperature', 'Admin\TemperatureController@index');
    Route::get('/temperature/filter', 'Admin\TemperatureController@filter');
    Route::get('/temperature/details', 'Admin\TemperatureController@details');
    Route::get('/temperature/update', 'Admin\TemperatureController@update');
    Route::get('/temperature/details_staff', 'Admin\TemperatureController@details_staff');
    Route::get('/temperature/update_staff', 'Admin\TemperatureController@update_staff');
    Route::get('/temperature/details_kontraktor', 'Admin\TemperatureController@details_kontraktor');
    Route::get('/temperature/update_kontraktor', 'Admin\TemperatureController@update_kontraktor');
    
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