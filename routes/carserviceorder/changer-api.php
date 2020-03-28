<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('carserviceorder/carmaker', 'carserviceorder\\API\\carmakerController@add');
    Route::put('carserviceorder/carmaker/{id}', 'carserviceorder\\API\\carmakerController@update');
    Route::delete('carserviceorder/carmaker/{id}', 'carserviceorder\\API\\carmakerController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('carserviceorder/car', 'carserviceorder\\API\\carController@add');
    Route::put('carserviceorder/car/{id}', 'carserviceorder\\API\\carController@update');
    Route::delete('carserviceorder/car/{id}', 'carserviceorder\\API\\carController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('carserviceorder/request', 'carserviceorder\\API\\requestController@add');
    Route::put('carserviceorder/request/{id}', 'carserviceorder\\API\\requestController@update');
    Route::delete('carserviceorder/request/{id}', 'carserviceorder\\API\\requestController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('carserviceorder/carmaker', 'carserviceorder\\API\\carmakerController@add');
    Route::put('carserviceorder/carmaker/{id}', 'carserviceorder\\API\\carmakerController@update');
    Route::delete('carserviceorder/carmaker/{id}', 'carserviceorder\\API\\carmakerController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('carserviceorder/car', 'carserviceorder\\API\\carController@add');
    Route::put('carserviceorder/car/{id}', 'carserviceorder\\API\\carController@update');
    Route::delete('carserviceorder/car/{id}', 'carserviceorder\\API\\carController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('carserviceorder/request', 'carserviceorder\\API\\requestController@add');
    Route::put('carserviceorder/request/{id}', 'carserviceorder\\API\\requestController@update');
    Route::delete('carserviceorder/request/{id}', 'carserviceorder\\API\\requestController@delete');
});
?>