<?php
//------------------------------------------------------------------------------------------------------
Route::get('common/date', 'common\\API\\dateController@list');
Route::get('common/date/{id}', 'common\\API\\dateController@get');
?>