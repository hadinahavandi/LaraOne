<?php
//------------------------------------------------------------------------------------------------------
Route::get('common/date', 'common\\api\\dateController@list');
Route::get('common/date/{id}', 'common\\api\\dateController@get');
?>