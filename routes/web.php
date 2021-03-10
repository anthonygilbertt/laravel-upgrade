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

Route::get('/', function ()
 {
  return redirect('home');
 });


Auth::routes();

// ------------original   -------------------------
/** correct  */Route::get('/home', 'HomeController@index');
/** correct  */Route::resource('trucks', 'truckController');
 /** correct  */ Route::post('trucks/changeStatus', array('as' => 'changeStatus', 'uses' => 'truckController@changeStatus'));

// Route::post('trucks/addTruck', array('as' => 'addTruck', 'uses' => 'truckController@addTruck'));

//  --------testing area    -------------------
//Route::get('/home', 'truckController@index')
//Route::get('/home', 'HomeController@index');
