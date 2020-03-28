<?php
//------------------------------------------------------------------------------------------------------
Route::get('appman/apperror', 'appman\\API\\apperrorController@list');
Route::get('appman/apperror/{id}', 'appman\\API\\apperrorController@get');
Route::post('appman/apperror', 'appman\\API\\apperrorController@add');

?>