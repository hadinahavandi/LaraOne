<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('placeman/place', 'placeman\\API\\PlaceController@add');
    Route::put('placeman/place/{id}', 'placeman\\API\\PlaceController@update');
    Route::delete('placeman/place/{id}', 'placeman\\API\\PlaceController@delete');
});
Route::group(['middleware' => 'auth:api'], function () {

    Route::get('/placeman/branches/userinfo', 'placeman\\api\\PlacemanController@getUserBranch');
    Route::post('/placeman/places/edit', 'placeman\\api\\PlacemanController@edit');
});
?>