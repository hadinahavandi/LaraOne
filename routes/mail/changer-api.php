<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('mail/mailpost', 'mail\\API\\mailpostController@add');
    Route::put('mail/mailpost/send/{id}', 'mail\\API\\mailpostController@sendToAll');
    Route::put('mail/mailpost/{id}', 'mail\\API\\mailpostController@update');
    Route::delete('mail/mailpost/{id}', 'mail\\API\\mailpostController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('mail/mailstatus', 'mail\\API\\mailstatusController@add');
    Route::put('mail/mailstatus/{id}', 'mail\\API\\mailstatusController@update');
    Route::delete('mail/mailstatus/{id}', 'mail\\API\\mailstatusController@delete');
});
?><?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('mail/mail', 'mail\\API\\mailController@add');
    Route::put('mail/mail/{id}', 'mail\\API\\mailController@update');
    Route::delete('mail/mail/{id}', 'mail\\API\\mailController@delete');
});
?>