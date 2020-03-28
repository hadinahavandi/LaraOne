<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::put('publicrelations/message/{id}', 'publicrelations\\API\\messageController@update');
    Route::delete('publicrelations/message/{id}', 'publicrelations\\API\\messageController@delete');
});
?>