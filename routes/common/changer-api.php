<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('common/date', 'common\\api\\dateController@add');
    Route::put('common/date/{id}', 'common\\api\\dateController@update');
    Route::delete('common/date/{id}', 'common\\api\\dateController@delete');
});
?>