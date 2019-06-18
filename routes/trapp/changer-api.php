<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/owningtype', 'trapp\\API\\owningtypeController@add');
    Route::put('trapp/owningtype/{id}', 'trapp\\API\\owningtypeController@update');
    Route::delete('trapp/owningtype/{id}', 'trapp\\API\\owningtypeController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/areatype', 'trapp\\API\\areatypeController@add');
    Route::put('trapp/areatype/{id}', 'trapp\\API\\areatypeController@update');
    Route::delete('trapp/areatype/{id}', 'trapp\\API\\areatypeController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/viewtype', 'trapp\\API\\viewtypeController@add');
    Route::put('trapp/viewtype/{id}', 'trapp\\API\\viewtypeController@update');
    Route::delete('trapp/viewtype/{id}', 'trapp\\API\\viewtypeController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('trapp/structuretype', 'trapp\\API\\structuretypeController@add');
    Route::put('trapp/structuretype/{id}', 'trapp\\API\\structuretypeController@update');
    Route::delete('trapp/structuretype/{id}', 'trapp\\API\\structuretypeController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('trapp/villa/price/{id}', 'trapp\\API\\villaController@GetOrderPrice');
    Route::get('trapp/villa/reservestart/{id}', 'trapp\\API\\villaController@StartReservePayment');
    Route::post('trapp/villa', 'trapp\\API\\villaController@add');
    Route::put('trapp/villa/{id}', 'trapp\\API\\villaController@update');
    Route::delete('trapp/villa/{id}', 'trapp\\API\\villaController@delete');
});
?>