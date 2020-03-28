<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('pages/page', 'pages\\API\\pageController@add');
    Route::put('pages/page/{id}', 'pages\\API\\pageController@update');
    Route::delete('pages/page/{id}', 'pages\\API\\pageController@delete');
});
?>