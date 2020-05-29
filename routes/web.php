<?php


Route::get('/','HomeController@index');


Route::get('/home','HomeController@index');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('invoice', function(){
    return view('invoice');
});

Route::get('oferta','HomeController@oferta');

Route::get('dashboard','HomeController@dashboard');

Route::get('detalle','HomeController@detalle');

Route::get('{path}','HomeController@index');
