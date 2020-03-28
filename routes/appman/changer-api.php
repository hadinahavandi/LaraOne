<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::delete('appman/apperror/{id}', 'appman\\API\\apperrorController@delete');
});
?>