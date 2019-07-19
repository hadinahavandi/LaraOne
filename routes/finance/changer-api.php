<?php
//------------------------------------------------------------------------------------------------------
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('finance/transaction', 'finance\\API\\transactionController@add');
    Route::put('finance/transaction/{id}', 'finance\\API\\transactionController@update');
    Route::delete('finance/transaction/{id}', 'finance\\API\\transactionController@delete');
});
?>