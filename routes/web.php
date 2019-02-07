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
Route::group(['middleware' => 'guest'], function () {
Route::get('/', function () {
            return view('/auth/login');
 });

});

Route::middleware(['auth'])->group(function () {
    //pantalla de inicio
    Route::get('/home', 'HomeController@index')->name('home');
    //muestra los usuarios en la bd
    Route::get('/usuarios', 'UserController@getUsers')->name('datatable.users');
    //crea un nuevo usuario
    Route::post('/usuarios/new', 'UserController@store')->name('datatable.users.new');
    //modifica el usuario
    Route::put('/usuarios/edit/{id}', 'UserController@update')->name('datatable.users.edit');
    //elimina el usuario
    Route::delete('/usuarios/delete/{id}', 'UserController@delete')->name('datatable.users.delete');


});
Route::get('/clear', function() {

           Artisan::call('cache:clear');
           Artisan::call('config:clear');
           Artisan::call('config:cache');
           Artisan::call('view:clear');

           return "Cleared!";

        });
Auth::routes();
