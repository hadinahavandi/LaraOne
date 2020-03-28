<?php
//------------------------------------------------------------------------------------------------------
Route::get('carserviceorder/carmaker', 'carserviceorder\\API\\carmakerController@list');
Route::get('carserviceorder/carmaker/{id}', 'carserviceorder\\API\\carmakerController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('carserviceorder/car', 'carserviceorder\\API\\carController@list');
Route::get('carserviceorder/car/{id}', 'carserviceorder\\API\\carController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('carserviceorder/request', 'carserviceorder\\API\\requestController@list');
Route::get('carserviceorder/request/{id}', 'carserviceorder\\API\\requestController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('carserviceorder/carmaker', 'carserviceorder\\API\\carmakerController@list');
Route::get('carserviceorder/carmaker/{id}', 'carserviceorder\\API\\carmakerController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('carserviceorder/car', 'carserviceorder\\API\\carController@list');
Route::get('carserviceorder/car/{id}', 'carserviceorder\\API\\carController@get');
?><?php
//------------------------------------------------------------------------------------------------------
Route::get('carserviceorder/request', 'carserviceorder\\API\\requestController@list');
Route::get('carserviceorder/request/{id}', 'carserviceorder\\API\\requestController@get');
?>