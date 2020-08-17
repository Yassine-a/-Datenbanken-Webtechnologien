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
    return view('home.start');
});

Route::get('start.php', 'StartController@view');

Route::get('Produkte.php','ProduktController@view');

Route::get('Detail.php','DetailsController@view');

Route::post('Detail.php','KommentareController@view');

Route::get('Login.php', array(
    'uses' => 'UserController@showLogin'
));
Route::get('login.php', array(
    'uses' => 'UserController@showLogin'
));


Route::post('Login.php', 'UserController@doLogin');

Route::get('logout.php', 'UserController@doLogout');

Route::post('Komment', 'KommentareController@store');

