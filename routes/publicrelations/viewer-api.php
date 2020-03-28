<?php
//------------------------------------------------------------------------------------------------------
Route::get('publicrelations/message', 'publicrelations\\API\\messageController@list');
Route::get('publicrelations/message/{id}', 'publicrelations\\API\\messageController@get');
Route::post('publicrelations/message', 'publicrelations\\API\\messageController@add');
?>