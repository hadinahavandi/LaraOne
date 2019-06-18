<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('common/date', 'common\\API\\dateController@add');
    Route::put('common/date/{id}', 'common\\API\\dateController@update');
    Route::delete('common/date/{id}', 'common\\API\\dateController@delete');
});
?>